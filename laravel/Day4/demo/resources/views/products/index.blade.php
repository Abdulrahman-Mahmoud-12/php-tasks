<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Products</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-success mb-4">All Products Page</h1>
        <a href="{{ route('products.create') }}" class="btn btn-info mb-3">Add Product</a>

        <div class="table-responsive">
            <table class="table table-striped table-hover w-100 shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                            <a href="{{ route('categories.show', $product->category->id) }}" class="fw-bold text-decoration-none">
                                {{ $product->category->name }}
                            </a>
                        </td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning btn-sm">View</a>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>