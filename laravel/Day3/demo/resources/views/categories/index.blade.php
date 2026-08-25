<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Categories</title>
</head>
<body>
    <x-navbar></x-navbar>
    <div class="container">
        <h1 class="text-center text-danger mb-3">All Categories Page</h1>
        <a href="{{ route('categories.create') }}" class="mb-3 d-inline-block">
            <x-button class="info" content="Add Categories"></x-button>
        </a>
        <table class="table table-striped w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->descripyion }}</td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-warning">View</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="post">
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