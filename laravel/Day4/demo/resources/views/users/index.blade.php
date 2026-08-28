<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>All Users (Admin)</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container my-4">
        <h1 class="text-center text-danger mb-4">All Users Page</h1>

        <div class="table-responsive">
            <table class="table table-striped table-hover w-75 m-auto shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm">View</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
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