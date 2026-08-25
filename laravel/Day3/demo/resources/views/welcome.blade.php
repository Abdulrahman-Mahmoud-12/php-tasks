<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Welcome - E-Commerce App</title>
</head>
<body class="bg-light">
    <x-navbar></x-navbar>

    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold text-primary mb-3">Welcome to E-Commerce System</h1>
        <p class="lead text-secondary mb-5">Manage Categories, Products, Users, and Orders seamlessly.</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-primary">Categories</h4>
                        <p class="card-text text-muted">Manage all product categories.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">View Categories</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-success">Products</h4>
                        <p class="card-text text-muted">Browse and manage store products.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success">View Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 py-4">
                    <div class="card-body">
                        <h4 class="card-title text-danger">Users</h4>
                        <p class="card-text text-muted">View users and their order history.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger">View Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>