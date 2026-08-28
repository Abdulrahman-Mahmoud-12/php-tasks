@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="mb-1">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none small text-muted"><i class="bi bi-chevron-left me-1"></i>Main Dashboard</a>
                <span class="text-muted small mx-1">/</span>
                <span class="small fw-semibold text-primary">Orders & Revenue Insights</span>
            </div>
            <h2 class="fw-bold mb-0"><i class="bi bi-graph-up-arrow me-2 text-success"></i>Orders & Sales Insights</h2>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-success text-white rounded-pill px-4 shadow-sm">
            <i class="bi bi-receipt me-1"></i> Orders Table
        </a>
    </div>

    <!-- Orders Metric Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Revenue</span>
                <h3 class="fw-bold text-success mb-0">${{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Orders</span>
                <h3 class="fw-bold text-primary mb-0">{{ $totalOrders }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Avg Order Value (AOV)</span>
                <h3 class="fw-bold text-warning mb-0">${{ number_format($avgOrderValue, 2) }}</h3>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card p-4 bg-white">
                <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Items Sold</span>
                <h3 class="fw-bold text-info mb-0">{{ $totalItemsSold }} units</h3>
            </div>
        </div>
    </div>

    <!-- Visualizations & Top Products -->
    <div class="row g-4 mb-4">
        <!-- Top Selling Products Chart -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-trophy-fill me-2 text-warning"></i>Top Selling Products (Units Sold)</h5>
                <div style="height: 320px;">
                    <canvas id="topProductsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products List -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4 bg-white">
                <h5 class="fw-bold mb-3 text-dark"><i class="bi bi-bag-check-fill me-2 text-primary"></i>Top Selling Products Breakdown</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th>Product</th>
                                <th>Units Sold</th>
                                <th>Revenue Generated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $item->product->name ?? 'Product' }}</td>
                                    <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $item->total_qty }} units</span></td>
                                    <td class="fw-bold text-success">${{ number_format($item->total_sales, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-muted text-center py-4">No order items recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Log Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>All Orders Log</h5>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Items Count</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th class="text-end">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            @php
                                $total = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                $itemsCount = $order->items->sum('quantity');
                            @endphp
                            <tr>
                                <td class="fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->user->name ?? 'Guest' }}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $itemsCount }} items</span></td>
                                <td class="fw-bold text-success">${{ number_format($total, 2) }}</td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Invoice</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $recentOrders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const topProducts = @json($topProducts);
        const labels = topProducts.map(p => p.product ? p.product.name : 'Item');
        const data = topProducts.map(p => p.total_qty);

        new Chart(document.getElementById('topProductsChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Units Sold',
                    data: data,
                    backgroundColor: 'rgba(13, 110, 253, 0.75)',
                    borderColor: '#0d6efd',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true } }
            }
        });
    });
</script>
@endpush
