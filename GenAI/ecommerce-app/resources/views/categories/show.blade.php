@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
        <i class="bi bi-arrow-left me-1"></i> All Categories
    </a>

    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-primary text-white p-4 p-lg-5" style="background: linear-gradient(135deg, #0d6efd 0%, #1e293b 100%);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold mb-2">Category Overview</span>
                <h2 class="display-5 fw-bold mb-2">{{ $category->name }}</h2>
                <p class="lead mb-0 text-white-50">{{ $category->description ?? 'Explore all products available under this category.' }}</p>
            </div>
            <div class="text-end d-none d-md-block">
                <div class="display-3 fw-bold">{{ $category->products->count() }}</div>
                <div class="text-white-50 small">Total Products</div>
            </div>
        </div>
    </div>

    <h4 class="fw-bold mb-4"><i class="bi bi-box-seam me-2 text-primary"></i>Products in {{ $category->name }}</h4>

    <div class="row g-4">
        @forelse($category->products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden stat-card">
                    <div class="bg-light p-4 text-center border-bottom">
                        <i class="bi bi-box-seam display-4 text-secondary opacity-50"></i>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-dark mb-2">{{ $product->name }}</h5>
                            <p class="text-muted small mb-3">{{ Str::limit($product->description, 80) }}</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                            <span class="fs-5 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="bi bi-box-x display-1"></i>
                <h4 class="mt-3">No Products in this Category</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection