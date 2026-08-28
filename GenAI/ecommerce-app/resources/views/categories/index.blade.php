@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-tags me-2 text-primary"></i>Categories Management</h2>
            <p class="text-muted small mb-0">Manage product categories and explore catalog collections.</p>
        </div>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Add Category
                </a>
            @endif
        @endauth
    </div>

    <div class="row g-4">
        @forelse($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 stat-card overflow-hidden">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 d-inline-block">
                                    <i class="bi bi-folder2-open fs-3"></i>
                                </div>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-semibold">
                                    {{ $category->products_count }} {{ Str::plural('Item', $category->products_count) }}
                                </span>
                            </div>

                            <h4 class="fw-bold text-dark mb-2">{{ $category->name }}</h4>
                            <p class="text-muted small mb-4">{{ $category->description ?? 'No category description available.' }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View Products <i class="bi bi-arrow-right ms-1"></i>
                            </a>

                            @auth
                                @if(Auth::user()->isAdmin())
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="d-inline" onsubmit="return confirm('Deleting this category will affect related products. Proceed?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <i class="bi bi-folder-x display-1"></i>
                <h4 class="mt-3">No Categories Found</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection