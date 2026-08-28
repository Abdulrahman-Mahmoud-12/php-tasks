@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-speedometer2 me-2 text-primary"></i>Admin Overview Dashboard</h2>
            <p class="text-muted small mb-0">Real-time performance analytics, stock alerts, and store insights.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard.categories') }}" class="btn btn-outline-info rounded-pill px-3">
                <i class="bi bi-pie-chart-fill me-1"></i> Categories Insights
            </a>
            <a href="{{ route('admin.dashboard.orders') }}" class="btn btn-outline-success rounded-pill px-3">
                <i class="bi bi-graph-up-arrow me-1"></i> Orders Insights
            </a>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card bg-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Revenue</span>
                        <h3 class="fw-bold text-success mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="bi bi-currency-dollar fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card bg-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Total Orders</span>
                        <h3 class="fw-bold text-primary mb-0">{{ $totalOrders }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="bi bi-cart-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card bg-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Products</span>
                        <h3 class="fw-bold text-info mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 stat-card bg-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold text-uppercase d-block mb-1">Customers</span>
                        <h3 class="fw-bold text-warning mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visualizations Row -->
    <div class="row g-4 mb-4">
        <!-- Categories Product Distribution Doughnut Chart -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pie-chart me-2 text-primary"></i>Category Distribution</h5>
                    <a href="{{ route('admin.dashboard.categories') }}" class="btn btn-sm btn-light rounded-pill">Details &rarr;</a>
                </div>
                <div class="card-body p-4 d-flex align-items-center justify-content-center" style="min-height: 300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Inventory Stock Health & Low Stock Alerts -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Inventory Alerts</h5>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">{{ $lowStockProducts->count() }} Alert(s)</span>
                </div>
                <div class="card-body p-4">
                    @if($lowStockProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted small">
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock Left</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $p)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $p->name }}</td>
                                            <td><span class="badge bg-light text-dark border">{{ $p->category->name ?? 'N/A' }}</span></td>
                                            <td>${{ number_format($p->price, 2) }}</td>
                                            <td><span class="badge bg-danger rounded-pill px-3">{{ $p->quantity }} units</span></td>
                                            <td class="text-end">
                                                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-outline-warning rounded-pill">Restock</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-success">
                            <i class="bi bi-check-circle-fill display-3"></i>
                            <h5 class="mt-3 fw-bold">Inventory Health Healthy</h5>
                            <p class="text-muted small">All products currently have sufficient stock levels.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Store Orders</h5>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">View All Orders</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items Count</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                            <th class="text-end">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            @php
                                $total = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                $itemsCount = $order->items->sum('quantity');
                            @endphp
                            <tr>
                                <td class="fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $order->user->name ?? 'Customer' }}</div>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </td>
                                <td><span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $itemsCount }} items</span></td>
                                <td class="fw-bold text-success">${{ number_format($total, 2) }}</td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        View Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No recent orders recorded.</td>
                            </tr>
                        @endforelse
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
        const categoryCounts = @json($categoryCounts);

        const ctx = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: categoryNames,
                datasets: [{
                    label: 'Products Count',
                    data: categoryCounts,
                    backgroundColor: [
                        '#0d6efd', '#0dcaf0', '#198754', '#ffc107', '#dc3545', '#6c757d', '#6610f2'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, font: { size: 12 } }
                    }
                }
            }
        });
    });
</script>
@endpush