@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Invoice No:</strong> {{ $purchaseReturn->purchase->invoice_no ?? 'N/A' }}</p>
                <p><strong>Return Quantity:</strong> {{ $purchaseReturn->product_quantity }}</p>
                <p><strong>Refund Amount:</strong> {{ number_format($purchaseReturn->refund_amount, 2) }}</p>
                <p><strong>Tax Amount:</strong> {{ number_format($purchaseReturn->tax_amount, 2) }}</p>
                <p><strong>Shipping Cost:</strong> {{ number_format($purchaseReturn->shipping_cost_adjustment, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $purchaseReturn->payment_method ?? 'N/A' }}</p>
                <p><strong>Status:</strong>
                    <span class="badge 
                            @if($purchaseReturn->status == 'completed') bg-success 
                            @elseif($purchaseReturn->status == 'pending') bg-warning 
                            @else bg-danger @endif">
                        {{ ucfirst($purchaseReturn->status) }}
                    </span>
                </p>
                <p><strong>Note:</strong> {{ $purchaseReturn->note ?? '—' }}</p>
            </div>
        </div>

        <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary mt-3">Back to List</a>
    </div>
@endsection