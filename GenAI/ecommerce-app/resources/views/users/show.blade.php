@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 850px;">
    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-pill mb-4">
        <i class="bi bi-arrow-left me-1"></i> Back to Users
    </a>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 p-lg-5 bg-white">
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary text-white rounded-circle display-5 fw-bold d-flex align-items-center justify-content-center me-4" style="width: 70px; height: 70px;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="fw-bold text-dark mb-1">{{ $user->name }}</h3>
                    <p class="text-muted mb-1"><i class="bi bi-envelope me-1"></i>{{ $user->email }}</p>
                    <span class="badge {{ $user->isAdmin() ? 'bg-warning text-dark' : 'bg-primary' }} rounded-pill px-3">
                        Role: {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-bold mb-3"><i class="bi bi-bag-check me-2 text-primary"></i>Customer Order History</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items Count</th>
                            <th>Total Price</th>
                            <th class="text-end">Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->orders as $order)
                            @php
                                $total = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                $itemsCount = $order->items->sum('quantity');
                            @endphp
                            <tr>
                                <td class="fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td><span class="badge bg-secondary-subtle text-secondary rounded-pill px-3">{{ $itemsCount }} items</span></td>
                                <td class="fw-bold text-success">${{ number_format($total, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Invoice</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">This user has not placed any orders yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
