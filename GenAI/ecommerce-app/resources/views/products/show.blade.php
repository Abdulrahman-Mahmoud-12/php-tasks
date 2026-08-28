@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Products
    </a>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5 bg-light p-5 text-center d-flex align-items-center justify-content-center border-end">
                <div>
                    <i class="bi bi-box-seam text-secondary display-1 opacity-75"></i>
                    <div class="mt-3">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fs-6">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-7 p-4 p-lg-5 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h2 class="fw-bold text-dark mb-0">{{ $product->name }}</h2>
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                            @endif
                        @endauth
                    </div>

                    <h3 class="text-primary fw-bold mb-4">${{ number_format($product->price, 2) }}</h3>

                    <h6 class="fw-bold text-dark mb-2">Description</h6>
                    <p class="text-muted mb-4">{{ $product->description ?? 'No description available.' }}</p>

                    <div class="row mb-4 g-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <small class="text-muted d-block">Stock Status</small>
                                <span class="fw-bold {{ $product->quantity > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $product->quantity > 0 ? $product->quantity . ' available' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded-3 text-center">
                                <small class="text-muted d-block">Category</small>
                                <span class="fw-bold text-dark">{{ $product->category->name ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4">
                    @auth
                        @if($product->quantity > 0)
                            <form method="POST" action="{{ route('orders.store') }}" class="row g-3 align-items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="col-4 col-sm-3">
                                    <label class="form-label small fw-bold mb-1">Quantity</label>
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control text-center rounded-3">
                                </div>
                                <div class="col-8 col-sm-9">
                                    <label class="form-label d-block small mb-1">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-sm">
                                        <i class="bi bi-bag-plus-fill me-2"></i> Place Order Now
                                    </button>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-lg w-100 rounded-pill" disabled>Out of Stock</button>
                        @endif
                    @else
                        <div class="bg-light p-3 rounded-3 text-center">
                            <p class="mb-2 text-muted">Please log in to place an order for this product.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Log In to Order</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
