<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Categories</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-danger mb-3">All Categories Page (Admin Only)</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-info mb-3">Add Category</a>

        <div class="table-responsive">
            <table class="table table-striped table-hover w-100 shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-warning btn-sm">View</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete category?')">Delete</button>
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