<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Order #{{ $order->id }}</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-dark mb-4">Order #{{ $order->id }} Details</h1>
    <p><strong>Customer:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
    <p><strong>Date:</strong> {{ $order->created_at }}</p>

    <h4 class="mt-4">Ordered Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price per Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $item->price }}</td>
                <td>${{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
</div>
</body>
</html>