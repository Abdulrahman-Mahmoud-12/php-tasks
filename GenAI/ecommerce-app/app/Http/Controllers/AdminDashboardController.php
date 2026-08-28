<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = OrderItem::sum(DB::raw('price * quantity')) ?: 0;

        // Category breakdown for Chart.js
        $categoriesData = Category::withCount('products')->get();
        $categoryNames = $categoriesData->pluck('name');
        $categoryCounts = $categoriesData->pluck('products_count');

        // Recent orders list
        $recentOrders = Order::with('user', 'items.product')->latest()->take(6)->get();

        // Stock health metrics
        $lowStockProducts = Product::where('quantity', '<', 5)->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalCategories', 'totalProducts', 
            'totalOrders', 'totalRevenue', 'categoryNames', 
            'categoryCounts', 'recentOrders', 'lowStockProducts'
        ));
    }

    public function categoriesInsights()
    {
        $categories = Category::with(['products'])->withCount('products')->get();

        $categoryNames = $categories->pluck('name');
        $productCounts = $categories->pluck('products_count');
        $stockValues = $categories->map(fn($c) => $c->products->sum(fn($p) => $p->price * $p->quantity));

        $totalCategories = $categories->count();
        $totalProducts = Product::count();

        return view('admin.dashboard-categories', compact(
            'categories', 'categoryNames', 'productCounts', 'stockValues', 'totalCategories', 'totalProducts'
        ));
    }

    public function ordersInsights()
    {
        $totalOrders = Order::count();
        $totalRevenue = OrderItem::sum(DB::raw('price * quantity')) ?: 0;
        $totalItemsSold = OrderItem::sum('quantity') ?: 0;
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;

        $recentOrders = Order::with('user', 'items.product')->latest()->paginate(10);

        // Top selling products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price * quantity) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        return view('admin.dashboard-orders', compact(
            'totalOrders', 'totalRevenue', 'totalItemsSold', 'avgOrderValue', 'recentOrders', 'topProducts'
        ));
    }
}
