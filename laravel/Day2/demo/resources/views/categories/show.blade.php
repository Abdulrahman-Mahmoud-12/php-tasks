<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $category->name }} Detail</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Category: {{ $category->name }}</h1>
    <p class="text-center">{{ $category->description }}</p>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary mb-4">Back to Categories</a>
    
    <h3 class="mt-4">Products in this Category</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>