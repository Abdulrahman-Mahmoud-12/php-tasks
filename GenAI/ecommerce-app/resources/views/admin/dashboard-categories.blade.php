@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Navigation / Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none small text-muted"><i class="bi bi-chevron-left me-1"></i>Main Dashboard</a>
                <span class="text-muted small mx-1">/</span>
                <span class="small fw-semibold text-primary">Categories Insights</span>
            </div>
            <h2 class="fw-bold mb-0"><i class="bi bi-tags-fill me-2 text-info"></i>Categories Data & Insights</h2>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-info text-white rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    <!-- Metric Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Categories</span>
                <h3 class="fw-bold text-info mb-0">{{ $totalCategories }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Catalog Products</span>
                <h3 class="fw-bold text-primary mb-0">{{ $totalProducts }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Avg Products per Category</span>
                <h3 class="fw-bold text-success mb-0">
                    {{ $totalCategories > 0 ? round($totalProducts / $totalCategories, 1) : 0 }}
                </h3>
            </div>
        </div>
    </div>

    <!-- Category Visualizations -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-bar-chart-fill me-2 text-info"></i>Products Count per Category</h5>
                <div style="height: 320px;">
                    <canvas id="categoryProductsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-cash-stack me-2 text-success"></i>Category Stock Value ($)</h5>
                <div style="height: 320px;">
                    <canvas id="categoryValueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Insights Breakdown Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-table me-2 text-primary"></i>Category Inventory & Metrics Table</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Products Count</th>
                            <th>Total Stock Quantity</th>
                            <th>Total Stock Value</th>
                            <th class="text-end">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            @php
                                $stockQty = $category->products->sum('quantity');
                                $stockValue = $category->products->sum(fn($p) => $p->price * $p->quantity);
                            @endphp
                            <tr>
                                <td class="fw-bold text-dark">
                                    <i class="bi bi-folder-fill text-info me-2"></i>{{ $category->name }}
                                </td>
                                <td class="text-muted small">{{ Str::limit($category->description, 60) }}</td>
                                <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $category->products_count }} items</span></td>
                                <td><span class="badge bg-secondary-subtle text-dark rounded-pill px-3">{{ $stockQty }} units</span></td>
                                <td class="fw-bold text-success">${{ number_format($stockValue, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('categories.show', $category->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">View</a>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryNames = @json($categoryNames);
        const productCounts = @json($productCounts);
        const stockValues = @json($stockValues);

        // Chart 1: Products Count per Category
        new Chart(document.getElementById('categoryProductsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: categoryNames,
                datasets: [{
                    label: 'Number of Products',
                    data: productCounts,
                    backgroundColor: 'rgba(13, 202, 240, 0.75)',
                    borderColor: '#0dcaf0',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart 2: Category Stock Value
        new Chart(document.getElementById('categoryValueChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: categoryNames,
                datasets: [{
                    label: 'Stock Value ($)',
                    data: stockValues,
                    backgroundColor: 'rgba(25, 135, 84, 0.75)',
                    borderColor: '#198754',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    });
</script>
@endpush
