<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Category</title>
</head>
<body>
    <x-navbar></x-navbar>
    <div class="container">
        <h1 class="text-info text-center mb-4">Update {{ $category->name }}</h1>
        <form class="w-75 m-auto border p-5" action="{{ route('categories.update', $category->id) }}" method="post">
            @method('put')
            @csrf
            <div class="mb-3">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" id="category_name" value="{{ old('name', $category->name) }}">
            </div>
            <div class="mb-3">
                @error('descripyion')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="category_description" class="form-label">Category Description</label>
                <input type="text" class="form-control" name="descripyion" id="category_description" value="{{ old('descripyion', $category->descripyion) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>