<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $product->name }} Details</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>
    <div class="container">
        <h1 class="text-center text-primary mb-4">{{ $product->name }} Details</h1>
        <div class="card w-75 m-auto p-4 shadow-sm">
            <p><strong>ID:</strong> {{ $product->id }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>
            <p><strong>Price:</strong> ${{ $product->price }}</p>
            <p><strong>Stock Quantity:</strong> {{ $product->quantity }}</p>
            <p><strong>Category:</strong> 
                <a href="{{ route('categories.show', $product->category->id) }}" class="fw-bold text-decoration-none">
                    {{ $product->category->name }}
                </a>
            </p>
            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
            </div>
        </div>
    </div>
</body>
</html>