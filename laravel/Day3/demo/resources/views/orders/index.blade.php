<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Orders</title>
</head>

<body class="bg-light">

    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-dark mb-4">All Orders Page</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover w-75 m-auto shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Items Count</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="fw-bold text-decoration-none">
                                #{{ $order->id }}
                            </a>
                        </td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->orderItems->count() }}</td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-warning btn-sm">View</a>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>