<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $user->name }} Profile</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-danger mb-4">{{ $user->name }} Profile</h1>

        <div class="card w-75 m-auto shadow-sm mb-5">
            <div class="card-header bg-dark text-white fw-bold">User Information</div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> <span class="badge bg-info">{{ ucfirst($user->role) }}</span></p>
                <a href="{{ route('users.index') }}" class="btn btn-success btn-sm">Back to Users List</a>
            </div>
        </div>

        <hr class="my-5">

        <h2 class="text-center text-success mb-3">All Orders for {{ $user->name }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-75 m-auto shadow-sm bg-white">
                <thead class="table-success">
                    <tr>
                        <th>Order ID</th>
                        <th>Created At</th>
                        <th>Total Items</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="fw-bold text-decoration-none">
                                #{{ $order->id }}
                            </a>
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->orderItems->count() }} Items</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm">View Order</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No orders found for this user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>