@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 850px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Back to Orders
        </a>
        <button onclick="window.print();" class="btn btn-outline-dark rounded-pill px-4">
            <i class="bi bi-printer me-1"></i> Print Invoice
        </button>
    </div>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <!-- Invoice Header -->
        <div class="card-header bg-dark text-white p-4 p-lg-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-1 text-white"><i class="bi bi-bag-heart-fill text-primary me-2"></i>NovaMart</h3>
                    <p class="text-white-50 small mb-0">Official Purchase Invoice</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <h5 class="fw-bold mb-0 text-primary">Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    <small class="text-white-50">Date: {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
                </div>
            </div>
        </div>

        <div class="card-body p-4 p-lg-5">
            <!-- Customer & Order Meta -->
            <div class="row mb-4 g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <h6 class="fw-bold text-uppercase text-muted fs-7 mb-2">Customer Details</h6>
                        <div class="fw-bold text-dark fs-5">{{ $order->user->name ?? 'Customer' }}</div>
                        <div class="text-muted small">{{ $order->user->email ?? 'N/A' }}</div>
                        <div class="badge bg-primary-subtle text-primary rounded-pill mt-2">Role: {{ ucfirst($order->user->role ?? 'user') }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <h6 class="fw-bold text-uppercase text-muted fs-7 mb-2">Order Information</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Fulfillment:</span>
                            <span class="badge bg-success text-white">Completed</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">Payment Method:</span>
                            <span class="fw-semibold text-dark">Credit Card (Simulated)</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Order Reference:</span>
                            <span class="fw-semibold text-dark">REF-{{ $order->id }}-{{ time() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <h5 class="fw-bold mb-3">Order Items Breakdown</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grandTotal = 0; @endphp
                        @foreach($order->items as $index => $item)
                            @php
                                $subtotal = $item->price * $item->quantity;
                                $grandTotal += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->product->name ?? 'Deleted Product' }}</div>
                                    <small class="text-muted">{{ $item->product->category->name ?? 'Uncategorized' }}</small>
                                </td>
                                <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                <td class="text-center"><span class="badge bg-secondary rounded-pill px-3">{{ $item->quantity }}</span></td>
                                <td class="text-end fw-bold">${{ number_format($subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold text-uppercase">Grand Total</td>
                            <td class="text-end fw-bold fs-4 text-success">${{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="alert alert-info border-0 rounded-3 d-flex align-items-center mb-0">
                <i class="bi bi-info-circle-fill fs-4 me-3 text-info"></i>
                <div class="small">
                    Thank you for shopping with NovaMart! If you have questions about your order invoice, please contact our 24/7 support or ask our AI Assistant.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
