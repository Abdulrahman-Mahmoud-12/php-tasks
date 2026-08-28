@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Banner Section -->
    <div class="bg-dark text-white py-5 position-relative overflow-hidden mb-5 rounded-4 shadow" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0d6efd 100%);">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill mb-3">
                        <i class="bi bi-stars me-1"></i> Smart E-Commerce Platform
                    </span>
                    <h1 class="display-3 fw-bold mb-3">Welcome to <span class="text-primary">NovaMart</span></h1>
                    <p class="lead mb-4 text-light opacity-75">
                        Discover top-tier products across curated categories. Powered by real-time analytics, RESTful APIs, and an interactive AI Shopping Assistant.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-pill fw-semibold shadow-sm">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Browse Products Catalog
                        </a>
                        <a href="{{ route('chatbot.index') }}" class="btn btn-outline-info btn-lg px-4 py-3 rounded-pill fw-semibold">
                            <i class="bi bi-robot me-2"></i> Ask AI Assistant
                        </a>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill fw-semibold">
                            <i class="bi bi-tags me-2"></i> Explore Categories
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0 d-none d-lg-block">
                    <div class="p-4 bg-white bg-opacity-10 rounded-4 backdrop-blur border border-white border-opacity-10 shadow-lg">
                        <i class="bi bi-shop-window text-info display-1"></i>
                        <h4 class="mt-3 text-white">Next-Gen Shopping</h4>
                        <p class="small text-light opacity-75">Fast ordering, comprehensive analytics, and automated insights.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Propositions & Features -->
    <div class="container mb-5">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 stat-card">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-lightning-charge-fill fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Fast Order Processing</h5>
                    <p class="text-muted small mb-0">Instant stock allocation and real-time inventory management.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 stat-card">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle mx-auto p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-robot fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">AI Shopping Helper</h5>
                    <p class="text-muted small mb-0">Get intelligent answers about pricing, specs, and stock details instantly.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 stat-card">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-code-square fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">RESTful API Driven</h5>
                    <p class="text-muted small mb-0">Clean JSON APIs for frontend widgets, orders, and admin metrics.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4 stat-card">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Admin Dashboard</h5>
                    <p class="text-muted small mb-0">Interactive visual charts for revenue, orders, and category metrics.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories Section (NO PRODUCTS) -->
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Explore Our Product Categories</h3>
                <p class="text-muted small mb-0">Select a category to view items in our catalog.</p>
            </div>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                View All Categories <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100 stat-card overflow-hidden">
                        <div class="card-body p-4 text-center">
                            <div class="bg-secondary bg-opacity-10 text-dark rounded-circle mx-auto p-3 mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                <i class="bi bi-folder-fill fs-2 text-primary"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $category->name }}</h5>
                            <p class="text-muted small mb-3 text-truncate">{{ $category->description ?? 'Explore items in this category' }}</p>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3">
                                {{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}
                            </span>
                            <div>
                                <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-dark rounded-pill px-3 w-100">
                                    Browse Category <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-folder-x fs-1"></i>
                    <p class="mt-2">No categories found yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- AI Assistant Feature Banner -->
    <div class="container mb-5">
        <div class="bg-primary text-white p-5 rounded-4 shadow-lg position-relative" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2"><i class="bi bi-robot me-2 text-warning"></i>Need Assistance? Talk to AI Assistant!</h2>
                    <p class="lead mb-0 text-white-50">
                        Our intelligent assistant is ready to help you find information on categories, product pricing, and order details in real-time.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('chatbot.index') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-pill fw-bold text-dark shadow-sm">
                        <i class="bi bi-chat-quote-fill me-2"></i> Launch AI Chatbot
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection