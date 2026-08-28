<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\AdminAnalyticsApiController;

// Public Home Page (MUST NOT CONTAIN PRODUCTS)
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Public Product Catalog Browsing
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Public Categories Browsing
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// AI Assistant Chatbot Page
Route::get('/chatbot', function () {
    return view('chatbot.index');
})->name('chatbot.index');

// Auth Route Middleware Group
Route::middleware(['auth'])->group(function () {
    
    // User & Admin Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        // Primary Admin Dashboard
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        // Secondary Dashboards
        Route::get('/admin/dashboard/categories', [AdminDashboardController::class, 'categoriesInsights'])->name('admin.dashboard.categories');
        Route::get('/admin/dashboard/orders', [AdminDashboardController::class, 'ordersInsights'])->name('admin.dashboard.orders');

        // Admin CRUD Management
        Route::resource('categories', CategoryController::class)->except(['index', 'show']);
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::resource('users', UserController::class)->except(['create', 'store']);
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });
});

// AI Assistant Endpoint
Route::post('/chat/ask', [ChatbotController::class, 'ask'])->name('chat.ask');

// ----------------------------------------------------
// RESTful API Routes
// ----------------------------------------------------
Route::prefix('api')->group(function () {
    // Public APIs
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/categories/{id}', [CategoryApiController::class, 'show']);
    Route::post('/chat/ask', [ChatbotController::class, 'ask']);

    // Protected APIs
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders', [OrderApiController::class, 'index']);
        Route::post('/orders', [OrderApiController::class, 'store']);
        Route::get('/orders/{id}', [OrderApiController::class, 'show']);

        // Admin Analytics APIs
        Route::middleware(['admin'])->group(function () {
            Route::post('/products', [ProductApiController::class, 'store']);
            Route::put('/products/{id}', [ProductApiController::class, 'update']);
            Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);

            Route::post('/categories', [CategoryApiController::class, 'store']);
            Route::put('/categories/{id}', [CategoryApiController::class, 'update']);
            Route::delete('/categories/{id}', [CategoryApiController::class, 'destroy']);

            Route::get('/admin/stats', [AdminAnalyticsApiController::class, 'dashboardStats']);
            Route::get('/admin/categories-insights', [AdminAnalyticsApiController::class, 'categoryInsights']);
            Route::get('/admin/orders-insights', [AdminAnalyticsApiController::class, 'orderInsights']);
        });
    });
});

require __DIR__.'/auth.php';
