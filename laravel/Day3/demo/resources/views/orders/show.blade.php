<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Order #{{ $order->id }} Details</title>
</head>

<body class="bg-light">

    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-dark mb-4">Order #{{ $order->id }} Details</h1>

        <!-- Order & Customer Summary -->
        <div class="card w-75 m-auto shadow-sm mb-5">
            <div class="card-header bg-dark text-white fw-bold">
                Order Summary
            </div>
            <div class="card-body">
                <p><strong>Customer:</strong> <a href="{{ route('users.show', $order->user->id) }}">{{ $order->user->name }}</a></p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Date Placed:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-sm">Back to Orders List</a>
            </div>
        </div>

        <hr class="my-5">

        <!-- Items Table -->
        <h2 class="text-center text-success mb-3">Order Items</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover w-75 m-auto shadow-sm bg-white">
                <thead class="table-success">
                    <tr>
                        <th>Product Name</th>
                        <th>Price Unit</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->orderItems as $item)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', $item->product->id) }}" class="fw-bold text-decoration-none">
                                {{ $item->product->name }}
                            </a>
                        </td>
                        <td>${{ $item->price }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ $item->price * $item->quantity }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No items in this order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>