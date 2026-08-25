<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Products</title>
</head>
<body>
    <x-navbar></x-navbar>
    <div class="container">
        <h1 class="text-center text-danger mb-4">All Products Page</h1>
        <a href="{{ route('products.create') }}" class="btn btn-info mb-3">Add Product</a>
        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category Name</th>
                    <th>Action</th>
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
                    <td class="d-flex gap-2">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-warning">View</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>