<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>E-Commerce Dashboard</title>
</head>
<body class="bg-light">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                🛒 E-Store Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Header -->
    <div class="container text-center my-5 py-4">
        <h1 class="display-4 fw-bold text-primary mb-3">Management Dashboard</h1>
        <p class="lead text-secondary">Navigate through entities and manage database operations seamlessly.</p>
    </div>

    <!-- Dashboard Quick Access Cards -->
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title text-danger">Users</h5>
                        <p class="card-text text-muted">Manage system users and view profiles.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm">View Users</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Categories</h5>
                        <p class="card-text text-muted">Organize product classification list.</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-sm">View Categories</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title text-success">Products</h5>
                        <p class="card-text text-muted">Track items, prices, and stock counts.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-sm">View Products</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm text-center py-4">
                    <div class="card-body">
                        <h5 class="card-title text-dark">Orders</h5>
                        <p class="card-text text-muted">Check customer purchases and details.</p>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-dark btn-sm">View Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>