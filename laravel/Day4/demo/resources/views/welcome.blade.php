<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Welcome - E-Commerce App</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold text-primary mb-3">Management Dashboard</h1>
        <p class="lead text-secondary mb-5">Manage Categories, Products, Users, and Orders seamlessly.</p>

        @auth
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-success">Products</h4>
                        <p class="card-text text-muted">Browse and manage store products.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success">View Products</a>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Categories</h4>
                        <p class="card-text text-muted">Manage product categories (Admin Only).</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">View Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-danger">Users</h4>
                        <p class="card-text text-muted">View system users list (Admin Only).</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger">View Users</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @else
        <div class="alert alert-info w-50 m-auto">
            Please <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to access system resources.
        </div>
        @endauth
    </div>
</body>
</html>