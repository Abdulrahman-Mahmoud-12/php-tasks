<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $category->name }} Category</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-danger mb-4">{{ $category->name }} Details</h1>

        <div class="card w-75 m-auto shadow-sm mb-5 p-4 bg-white">
            <p><strong>ID:</strong> {{ $category->id }}</p>
            <p><strong>Name:</strong> {{ $category->name }}</p>
            <p><strong>Description:</strong> {{ $category->description }}</p>
            <div class="d-flex gap-2">
                <a href="{{ route('categories.index') }}" class="btn btn-success btn-sm">Back</a>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
            </div>
        </div>

        <hr class="my-5">

        <h2 class="text-center text-success mb-3">Products in {{ $category->name }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover w-75 m-auto shadow-sm bg-white">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($category->products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->price }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm">View Product</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No products in this category.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>