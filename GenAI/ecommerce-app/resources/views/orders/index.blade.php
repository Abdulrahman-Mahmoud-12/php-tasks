@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-receipt me-2 text-primary"></i>Orders History</h2>
            <p class="text-muted small mb-0">
                {{ Auth::user()->isAdmin() ? 'All customer orders across the platform.' : 'Track your placed store orders.' }}
            </p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-plus-lg me-1"></i> Place New Order
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            @if(Auth::user()->isAdmin())
                                <th>Customer</th>
                            @endif
                            <th>Order Date</th>
                            <th>Items Count</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $total = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                $itemsCount = $order->items->sum('quantity');
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                @if(Auth::user()->isAdmin())
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $order->user->name ?? 'Guest User' }}</div>
                                        <div class="text-muted small">{{ $order->user->email ?? 'N/A' }}</div>
                                    </td>
                                @endif
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $itemsCount }} {{ Str::plural('item', $itemsCount) }}</span></td>
                                <td class="fw-bold text-success">${{ number_format($total, 2) }}</td>
                                <td><span class="badge bg-success-subtle text-success rounded-pill px-3 py-1"><i class="bi bi-check-circle me-1"></i> Completed</span></td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                        <i class="bi bi-eye me-1"></i> View Invoice
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <form method="POST" action="{{ route('orders.destroy', $order->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel and delete this order?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-cart-x display-1"></i>
                                    <h4 class="mt-3">No Orders Found</h4>
                                    <p>No orders have been placed yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
