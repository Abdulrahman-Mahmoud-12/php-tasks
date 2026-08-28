<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Product</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-info text-center mb-4">Edit Product: {{ $product->name }}</h1>
        <form class="w-75 m-auto border bg-white p-5 rounded shadow-sm" action="{{ route('products.update', $product->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}">
            </div>
            <div class="mb-3">
                @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="mb-3">
                @error('price') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price) }}">
            </div>
            <div class="mb-3">
                @error('quantity') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $product->quantity) }}">
            </div>
            <div class="mb-3">
                @error('category_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>
</html>