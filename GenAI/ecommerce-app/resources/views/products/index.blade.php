@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header & Action Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-grid me-2 text-primary"></i>Products Catalog</h2>
            <p class="text-muted small mb-0">Browse all available products in our store store catalog.</p>
        </div>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('products.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add New Product
                </a>
            @endif
        @endauth
    </div>

    <!-- Filter & Search Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search products by name or description..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100 rounded-3">Filter</button>
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-3"><i class="bi bi-x-lg"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden stat-card d-flex flex-column">
                    <div class="bg-light p-4 text-center border-bottom position-relative" style="min-height: 160px;">
                        <i class="bi bi-box-seam display-4 text-secondary opacity-50"></i>
                        <span class="position-absolute top-0 end-0 m-3 badge rounded-pill {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-semibold rounded-pill px-3 py-1">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $product->description ?? 'No detailed description available.' }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <div>
                                <span class="text-muted small d-block">Price</span>
                                <span class="fs-4 fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                            </div>
                            <div class="d-flex gap-1">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="View Details">
                                    <i class="bi bi-eye"></i> Details
                                </a>
                                @auth
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="bi bi-box-x display-1"></i>
                <h4 class="mt-3">No Products Found</h4>
                <p>Try clearing filters or search terms.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
