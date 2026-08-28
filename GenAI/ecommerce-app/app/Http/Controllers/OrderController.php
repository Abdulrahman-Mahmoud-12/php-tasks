<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $orders = Order::with('user', 'items.product')->latest()->get();
        } else {
            $orders = Order::where('user_id', auth()->id())->with('items.product')->latest()->get();
        }
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if (!auth()->user()->isAdmin() && $order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['user', 'items.product']);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $product->decrement('quantity', $request->quantity);

        $order = Order::create(['user_id' => auth()->id()]);
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
