<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])->get();
        return view('orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return to_route('orders.index');
    }
}