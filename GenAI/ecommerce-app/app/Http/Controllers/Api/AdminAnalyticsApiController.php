<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsApiController extends Controller
{
    public function dashboardStats()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = OrderItem::sum(DB::raw('price * quantity')) ?: 0;

        // Categories product distribution
        $categoriesData = Category::withCount('products')->get();
        $categoryLabels = $categoriesData->pluck('name');
        $categoryCounts = $categoriesData->pluck('products_count');

        // Recent monthly or daily sales overview
        $recentOrders = Order::with('user', 'items')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer' => $order->user->name ?? 'Guest',
                    'email' => $order->user->email ?? 'N/A',
                    'total' => $order->items->sum(fn($i) => $i->price * $i->quantity),
                    'date' => $order->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'summary' => [
                'total_users' => $totalUsers,
                'total_categories' => $totalCategories,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => round($totalRevenue, 2),
            ],
            'chart_category_distribution' => [
                'labels' => $categoryLabels,
                'data' => $categoryCounts,
            ],
            'recent_orders' => $recentOrders,
        ]);
    }

    public function categoryInsights()
    {
        $categories = Category::with(['products'])->withCount('products')->get()->map(function ($cat) {
            $stockQty = $cat->products->sum('quantity');
            $stockValue = $cat->products->sum(fn($p) => $p->price * $p->quantity);

            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'description' => $cat->description,
                'products_count' => $cat->products_count,
                'total_stock_quantity' => $stockQty,
                'total_stock_value' => round($stockValue, 2),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $categories,
            'chart' => [
                'labels' => $categories->pluck('name'),
                'products_count' => $categories->pluck('products_count'),
                'stock_value' => $categories->pluck('total_stock_value'),
            ]
        ]);
    }

    public function orderInsights()
    {
        $totalOrders = Order::count();
        $totalRevenue = OrderItem::sum(DB::raw('price * quantity')) ?: 0;
        $totalItemsSold = OrderItem::sum('quantity') ?: 0;
        $avgOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;

        // Top ordered products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'summary' => [
                'total_orders' => $totalOrders,
                'total_revenue' => round($totalRevenue, 2),
                'total_items_sold' => $totalItemsSold,
                'avg_order_value' => round($avgOrderValue, 2),
            ],
            'top_products' => $topProducts,
        ]);
    }
}
