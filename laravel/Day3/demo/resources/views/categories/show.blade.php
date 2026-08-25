<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>{{ $category->name }} Category</title>
</head>

<body class="bg-light">

    <x-navbar></x-navbar>

    <div class="container my-4">
        <!-- تفاصيل القسم -->
        <h1 class="text-center text-danger mb-4">{{ $category->name }} Category Details</h1>

        <table class="table table-striped w-75 m-auto shadow-sm bg-white mb-5">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->descripyion }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('categories.index') }}" class="btn btn-success btn-sm">Back</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete category?')">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr class="my-5">

        <!-- جدول المنتجات المترابطة بالقسم -->
        <h2 class="text-center text-success mb-3">Products in {{ $category->name }} Category</h2>

        <table class="table table-bordered table-hover w-75 m-auto shadow-sm bg-white">
            <thead class="table-success">
                <tr>
                    <th>Product ID</th>
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
                    <td colspan="5" class="text-center text-muted">No products available in this category.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>