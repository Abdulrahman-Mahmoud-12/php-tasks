<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Category</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-info text-center mb-4">Update {{ $category->name }}</h1>
        <form class="w-75 m-auto border bg-white p-5 rounded shadow-sm" action="{{ route('categories.update', $category->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                @error('name') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" id="category_name" value="{{ old('name', $category->name) }}">
            </div>
            <div class="mb-3">
                @error('description') <div class="alert alert-danger">{{ $message }}</div> @enderror
                <label for="category_description" class="form-label">Category Description</label>
                <input type="text" class="form-control" name="description" id="category_description" value="{{ old('description', $category->description) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update Category</button>
        </form>
    </div>
</body>
</html>