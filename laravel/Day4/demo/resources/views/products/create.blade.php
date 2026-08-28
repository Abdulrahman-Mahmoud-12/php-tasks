<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create Product</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-success text-center mb-4">Create New Product</h1>
        <form class="w-75 m-auto border bg-white p-5 rounded shadow-sm" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Product Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                @error('price') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Price</label>
                <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price') }}">
            </div>
            <div class="mb-3">
                @error('quantity') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="quantity" value="{{ old('quantity') }}">
            </div>
            <div class="mb-3">
                @error('category_id') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Save Product</button>
        </form>
    </div>
</body>
</html>