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
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $userPrompt = trim($request->input('message'));

        $currentUser = auth()->user();
        $role = ($currentUser && $currentUser->isAdmin()) ? 'admin' : 'user';

        // 1. Build System Instruction with strict role boundaries & dynamic database context
        $systemInstruction = $this->buildSystemInstruction($role);

        // 2. Fetch OpenRouter API Key
        $apiKey = env('OPENROUTER_API_KEY');
        if (empty($apiKey)) {
            return response()->json([
                'reply' => 'The AI assistant service is missing an API key.'
            ], 500);
        }

        // 3. Call OpenRouter API
        $aiReply = $this->callOpenRouterApi($apiKey, $systemInstruction, $userPrompt);

        if ($aiReply !== null) {
            return response()->json(['reply' => $aiReply]);
        }

        return response()->json([
            'reply' => 'I am unable to generate a response at the moment. Please try again shortly.'
        ], 500);
    }

    /**
     * Sends user prompt & database context to OpenRouter API
     */
    private function callOpenRouterApi(string $apiKey, string $systemInstruction, string $userPrompt): ?string
    {
        // Free-tier model slugs on OpenRouter
        $models = [
            'nvidia/nemotron-3.5-lightning:freee'
        ];

        foreach ($models as $model) {
            try {
                $response = Http::withoutVerifying() // Bypasses local cURL SSL check
                    ->timeout(12)
                    ->withHeaders([
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type' => 'application/json',
                    ])
                    ->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model' => $model,
                        'messages' => [
                            ['role' => 'system', 'content' => $systemInstruction],
                            ['role' => 'user', 'content' => $userPrompt],
                        ],
                        'temperature' => 0.3,
                        'max_tokens' => 600,
                    ]);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $reply = $responseData['choices'][0]['message']['content'] ?? null;
                    if ($reply) {
                        return trim($reply);
                    }
                } else {
                    Log::error("OpenRouter API Error [Model: {$model}]: " . $response->status() . " - " . $response->body());
                }
            } catch (\Exception $e) {
                Log::error("OpenRouter API Exception [Model: {$model}]: " . $e->getMessage());
            }
        }

        return null;
    }

    private function buildSystemInstruction(string $role): string
    {
        $topSelling = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product.category')
            ->get();

        if ($role === 'admin') {
            $totalSales = OrderItem::sum(DB::raw('price * quantity')) ?: 0;
            $orderCount = Order::count();
            $customerCount = User::where('role', 'user')->count();
            $adminCount = User::where('role', 'admin')->count();
            $avgOrder = $orderCount > 0 ? round($totalSales / $orderCount, 2) : 0;

            $categories = Category::with(['products'])->withCount('products')->get()->map(function ($c) {
                return [
                    'category_name' => $c->name,
                    'description' => $c->description,
                    'product_count' => $c->products_count,
                    'total_stock_value' => round($c->products->sum(fn($p) => $p->price * $p->quantity), 2),
                ];
            });

            $inventory = Product::with('category')->get()->map(function ($p) {
                return [
                    'product_name' => $p->name,
                    'price' => (float) $p->price,
                    'quantity_in_stock' => (int) $p->quantity,
                    'category' => $p->category->name ?? 'General',
                    'description' => $p->description,
                ];
            });

            $topSellingAdmin = $topSelling->map(function ($i) {
                return [
                    'product_name' => $i->product->name ?? 'Product',
                    'units_sold' => (int) $i->total_qty,
                    'revenue_generated' => (float) round($i->total_sales, 2),
                ];
            });

            $dbContextJson = json_encode([
                'financial_summary' => [
                    'total_sales_revenue' => round($totalSales, 2),
                    'total_order_volume' => $orderCount,
                    'average_transaction_value' => $avgOrder,
                ],
                'user_demographics' => [
                    'customer_count' => $customerCount,
                    'admin_count' => $adminCount,
                ],
                'top_selling_products' => $topSellingAdmin,
                'categories_breakdown' => $categories,
                'inventory_health_data' => $inventory,
            ], JSON_PRETTY_PRINT);

            return "You are an AI Business & Financial Operations Analyst for our E-Commerce Store. You are conversing directly with the SYSTEM ADMINISTRATOR.

ROLE & BEHAVIOR INSTRUCTIONS:
- You have full access to backend metrics, revenues, top sellers, and stock levels provided in the context below.
- Analyze store health, flag low stock items (quantity <= 5), calculate financial metrics, and give actionable operational advice.
- Answer any question dynamically based on the provided live store database context.
- Format responses clearly using bold text, bullet points, or markdown tables.

LIVE STORE DATABASE CONTEXT (ADMIN LEVEL):
{$dbContextJson}";
        }

        // PUBLIC CUSTOMER CONTEXT
        $categories = Category::withCount('products')->get()->map(function ($c) {
            return [
                'category_name' => $c->name,
                'description' => $c->description,
                'available_item_count' => $c->products_count,
            ];
        });

        $products = Product::with('category')->get()->map(function ($p) {
            return [
                'product_name' => $p->name,
                'price' => (float) $p->price,
                'category' => $p->category->name ?? 'General',
                'description' => $p->description,
                'in_stock' => $p->quantity > 0,
            ];
        });

        $bestSellersPublic = $topSelling->map(function ($i) {
            return [
                'product_name' => $i->product->name ?? 'Product',
                'price' => (float) ($i->product->price ?? 0),
                'category' => $i->product->category->name ?? 'General',
            ];
        });

        $dbContextJson = json_encode([
            'categories' => $categories,
            'products_catalog' => $products,
            'best_sellers' => $bestSellersPublic,
        ], JSON_PRETTY_PRINT);

        return "You are the Official Generative AI Shopping Assistant for our E-Commerce Store. You are conversing with a SHOPPER / CUSTOMER.

STRICT ROLE & SECURITY RESTRICTIONS:
1. CUSTOMER ADVISOR MODE: Help users discover products, recommend best sellers, compare prices, explain product descriptions, and give purchasing guidance based on the catalog data below.
2. STRICT DATA BOUNDARIES (CRITICAL):
   - You ONLY know public catalog information (Name, Price, Category, Description, Availability).
   - NEVER reveal exact stock quantities, revenue, total store sales, user lists, or internal primary key database IDs.
   - REFUSAL PROTOCOL: If asked for internal stock counts, financial metrics, or user data, politely decline by stating that you can only provide shopping catalog guidance and pricing assistance.
3. Be helpful, enthusiastic, and provide detailed step-by-step guidance.

LIVE STORE DATABASE CONTEXT (PUBLIC CATALOG):
{$dbContextJson}";
    }
}