<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $userPrompt = trim($request->input('message'));
        
        $currentUser = auth()->user();
        $isAdmin = $currentUser && $currentUser->isAdmin();

        // 1. Build context based on user authorization level
        if ($isAdmin) {
            $systemInstruction = $this->getAdminContext();
        } else {
            $systemInstruction = $this->getUserContext();
        }

        // 2. Try Gemini API first if key is present
        $apiKey = env('GEMINI_API_KEY');
        if (!empty($apiKey) && strlen($apiKey) > 20 && !str_contains($apiKey, 'AQ.')) {
            $reply = $this->callGeminiApi($apiKey, $systemInstruction, $userPrompt);
            if ($reply !== null) {
                return response()->json(['reply' => $reply]);
            }
        }

        // 3. Strict Direct Assistant Engine Fallback
        $fallbackReply = $this->generateDirectStrictReply($userPrompt, $isAdmin);
        return response()->json(['reply' => $fallbackReply]);
    }

    private function callGeminiApi(string $apiKey, string $systemInstruction, string $userPrompt): ?string
    {
        $models = ['gemini-1.5-flash', 'gemini-2.0-flash', 'gemini-2.5-flash'];

        foreach ($models as $model) {
            try {
                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                $response = Http::timeout(4)
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($endpoint, [
                        'system_instruction' => [
                            'parts' => [
                                ['text' => $systemInstruction . "\nIMPORTANT: Answer the user's specific question directly, concisely, and strictly without unnecessary preamble."]
                            ]
                        ],
                        'contents' => [
                            [
                                'role' => 'user',
                                'parts' => [['text' => $userPrompt]]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.1,
                            'maxOutputTokens' => 500,
                        ]
                    ]);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if ($reply) {
                        return trim($reply);
                    }
                }
            } catch (\Exception $e) {
                // Continue
            }
        }

        return null;
    }

    private function generateDirectStrictReply(string $prompt, bool $isAdmin): string
    {
        $raw = $prompt;
        $lower = strtolower($prompt);

        // ----------------------------------------------------
        // A. ADMIN SPECIFIC STRICT QUERIES
        // ----------------------------------------------------
        if ($isAdmin) {
            // Revenue / Financials
            if (Str::contains($lower, ['revenue', 'sales', 'money', 'earned', 'financial', 'income'])) {
                $revenue = OrderItem::sum(DB::raw('price * quantity')) ?: 0;
                $ordersCount = Order::count();
                $avgOrder = $ordersCount > 0 ? ($revenue / $ordersCount) : 0;
                return "📊 **Total Revenue**: **$" . number_format($revenue, 2) . "** across **{$ordersCount} orders** (Average Order Value: **$" . number_format($avgOrder, 2) . "**).";
            }

            // Low Stock / Stock Health
            if (Str::contains($lower, ['low stock', 'out of stock', 'stock health', 'replenish', 'inventory alert'])) {
                $lowStock = Product::where('quantity', '<', 5)->get();
                if ($lowStock->count() > 0) {
                    $list = $lowStock->map(fn($p) => "• **{$p->name}**: {$p->quantity} units left (\${$p->price})")->implode("\n");
                    return "⚠️ **Low Stock Alert ({$lowStock->count()} items)**:\n{$list}";
                }
                return "✅ **Stock Health**: All catalog products have 5 or more units in stock.";
            }

            // Users / Customers Count
            if (Str::contains($lower, ['user count', 'customer count', 'registered users', 'how many users', 'how many customers'])) {
                $usersCount = User::where('role', 'user')->count();
                $adminsCount = User::where('role', 'admin')->count();
                return "👥 **Users Summary**: **{$usersCount}** customers and **{$adminsCount}** administrators registered.";
            }

            // Top Selling Products
            if (Str::contains($lower, ['best seller', 'top seller', 'top selling', 'most sold', 'popular item'])) {
                $top = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_sales'))
                    ->groupBy('product_id')
                    ->orderByDesc('total_qty')
                    ->with('product')
                    ->take(3)
                    ->get();

                if ($top->count() > 0) {
                    $list = $top->map(fn($i) => "• **" . ($i->product->name ?? 'Product') . "**: {$i->total_qty} units sold ($" . number_format($i->total_sales, 2) . ")")->implode("\n");
                    return "🏆 **Top Selling Products**:\n{$list}";
                }
                return "No sales data recorded yet to compute top selling items.";
            }
        }

        // ----------------------------------------------------
        // B. PRICE RANGE & BUDGET QUERIES
        // ----------------------------------------------------
        if (preg_match('/under \$?(\d+)/i', $lower, $matches) || preg_match('/less than \$?(\d+)/i', $lower, $matches) || preg_match('/cheaper than \$?(\d+)/i', $lower, $matches)) {
            $maxPrice = (float) $matches[1];
            $products = Product::where('price', '<=', $maxPrice)->orderBy('price', 'asc')->take(5)->get();
            if ($products->count() > 0) {
                $list = $products->map(fn($p) => "• **{$p->name}** - $" . number_format($p->price, 2))->implode("\n");
                return "💰 **Products under $" . number_format($maxPrice, 2) . "**:\n{$list}\n\nView all on the [Products Catalog](/products).";
            }
            return "No products found under $" . number_format($maxPrice, 2) . ".";
        }

        if (Str::contains($lower, ['cheapest', 'lowest price', 'inexpensive'])) {
            $cheapest = Product::orderBy('price', 'asc')->first();
            if ($cheapest) {
                return "🏷️ **Cheapest Product**: **{$cheapest->name}** priced at **$" . number_format($cheapest->price, 2) . "**. [View Details](/products/{$cheapest->id})";
            }
        }

        if (Str::contains($lower, ['most expensive', 'highest price', 'premium'])) {
            $pricy = Product::orderBy('price', 'desc')->first();
            if ($pricy) {
                return "💎 **Most Premium Product**: **{$pricy->name}** priced at **$" . number_format($pricy->price, 2) . "**. [View Details](/products/{$pricy->id})";
            }
        }

        // ----------------------------------------------------
        // C. DIRECT PRODUCT / NAME SEARCH QUERY
        // ----------------------------------------------------
        // Clean out noise words to extract search term
        $stopWords = ['do', 'you', 'have', 'any', 'what', 'is', 'the', 'price', 'of', 'how', 'much', 'for', 'show', 'me', 'tell', 'about', 'details', 'can', 'i', 'buy', 'search', 'find', 'product', 'item'];
        $words = array_filter(explode(' ', preg_replace('/[^\w\s]/', '', $lower)), fn($w) => strlen($w) > 2 && !in_array($w, $stopWords));
        
        if (!empty($words)) {
            $searchTerm = implode(' ', $words);
            
            // 1. Try exact or partial product match
            $matchedProducts = Product::with('category')
                ->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('name', 'like', "%{$word}%")
                          ->orWhere('description', 'like', "%{$word}%");
                    }
                })
                ->take(4)
                ->get();

            if ($matchedProducts->count() > 0) {
                if ($matchedProducts->count() === 1) {
                    $p = $matchedProducts->first();
                    return "📍 **{$p->name}**\n• **Price**: $" . number_format($p->price, 2) . "\n• **Category**: " . ($p->category->name ?? 'General') . "\n• **Status**: " . ($p->quantity > 0 ? "In Stock ({$p->quantity} available)" : "Out of Stock") . "\n• **Description**: " . ($p->description ?? 'N/A') . "\n\n👉 [View & Order Product](/products/{$p->id})";
                }

                $list = $matchedProducts->map(fn($p) => "• **[{$p->name}](/products/{$p->id})** - $" . number_format($p->price, 2) . " (" . ($p->category->name ?? 'General') . ")")->implode("\n");
                return "🔍 **Products Matching your search ('{$searchTerm}')**:\n{$list}";
            }

            // 2. Try category match
            $matchedCategory = Category::with('products')
                ->where(function ($q) use ($words) {
                    foreach ($words as $word) {
                        $q->orWhere('name', 'like', "%{$word}%");
                    }
                })
                ->first();

            if ($matchedCategory) {
                $prods = $matchedCategory->products->take(5);
                if ($prods->count() > 0) {
                    $list = $prods->map(fn($p) => "• **{$p->name}** - $" . number_format($p->price, 2))->implode("\n");
                    return "🏷️ **Products in Category '{$matchedCategory->name}'**:\n{$list}\n\n👉 [View Category Page](/categories/{$matchedCategory->id})";
                }
                return "🏷️ Category **{$matchedCategory->name}** exists but currently has no products.";
            }
        }

        // ----------------------------------------------------
        // D. CATEGORY LIST & ORDER INSTRUCTIONS
        // ----------------------------------------------------
        if (Str::contains($lower, ['category', 'categories', 'types', 'section', 'departments'])) {
            $categories = Category::withCount('products')->get();
            if ($categories->count() > 0) {
                $list = $categories->map(fn($c) => "• **[{$c->name}](/categories/{$c->id})**: {$c->products_count} items")->implode("\n");
                return "🏷️ **Available Categories**:\n{$list}";
            }
            return "No categories currently available.";
        }

        if (Str::contains($lower, ['how to order', 'place order', 'how do i buy', 'purchase'])) {
            return "📦 **Steps to Place an Order**:\n1. Open our [Products Catalog](/products).\n2. Click on the product you want to buy.\n3. Choose quantity and click **Place Order Now**.\n4. View your invoice anytime under [My Orders](/orders).";
        }

        if (Str::contains($lower, ['hi', 'hello', 'hey', 'greetings'])) {
            return "Hello! 👋 I am your NovaMart AI Assistant. How can I assist you with our products, categories, or store catalog today?";
        }

        // ----------------------------------------------------
        // E. STRICT DIRECT UNMATCHED FALLBACK
        // ----------------------------------------------------
        return "I searched our store catalog for **\"{$raw}\"**, but couldn't find a direct matching product or category. \n\n• Browse our full **[Products Catalog](/products)**\n• Explore all **[Categories](/categories)**\n• Or ask me: *\"What is the price of [Product Name]?\"* or *\"What categories do you have?\"*";
    }

    private function getUserContext(): string
    {
        $products = Product::with('category')->get(['id', 'name', 'price', 'description', 'category_id']);
        $categories = Category::all(['id', 'name', 'description']);

        $catalogSummary = "Categories:\n" . $categories->toJson() . "\n\nProducts Available:\n" . $products->toJson();

        return "You are a customer assistant for NovaMart E-Commerce store.
STRICT INSTRUCTIONS:
1. Answer the user's specific question directly, accurately, and concisely.
2. If asked about a product, give its exact price, category, and direct detail link.
3. If asked about categories, list available category names.
4. DO NOT reveal internal inventory stock quantities, user accounts, or financial metrics to customers.
5. Do not include vague greetings or generic filler paragraphs. Be direct.

Store Catalog Context:
{$catalogSummary}";
    }

    private function getAdminContext(): string
    {
        $totalSales = OrderItem::sum(DB::raw('price * quantity')) ?: 0;
        $orderCount = Order::count();
        $userCount = User::where('role', 'user')->count();
        $products = Product::all(['id', 'name', 'price', 'quantity']);
        $categories = Category::withCount('products')->get(['id', 'name', 'products_count']);

        $adminData = [
            'total_revenue' => $totalSales,
            'total_orders' => $orderCount,
            'total_customers' => $userCount,
            'product_inventory' => $products,
            'category_counts' => $categories
        ];

        return "You are an AI Business Analytics Assistant for the Store Administrator.
STRICT INSTRUCTIONS:
1. Answer the System Admin's specific question directly and with exact numerical figures.
2. When asked about revenue, report total revenue and order count directly.
3. When asked about stock health, highlight items with quantity < 5.
4. Be precise, concise, and analytical.

Backend Store Metrics:
" . json_encode($adminData);
    }
}
