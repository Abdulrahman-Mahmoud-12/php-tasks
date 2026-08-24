<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $user->name }} Profile</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-danger mb-4">{{ $user->name }} Page</h1>
        <table class="table table-striped w-75 m-auto mb-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.index') }}" class="btn btn-success btn-sm">Back</a>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>
        <h2 class="text-center text-success mb-3">All Orders</h2>
        <table class="table table-bordered w-75 m-auto">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Created At</th>
                    <th>Items Count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($user->orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->orderItems->count() }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">No orders found for this user.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>