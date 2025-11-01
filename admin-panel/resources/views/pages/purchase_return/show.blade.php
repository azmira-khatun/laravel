@extends('master')

@section('content')
<div class="container mt‑4">
    <h1>Purchase Return Details (ID: {{ $purchaseReturn->id }})</h1>

    <div class="card mb‑4">
        <div class="card-body">
            <h5 class="card-title">Original Purchase</h5>
            <p class="card-text">
                Invoice No: <strong>{{ $purchaseReturn->purchase->invoice_no ?? '-' }}</strong><br>
                Vendor: <strong>{{ $purchaseReturn->vendor->name ?? '-' }}</strong><br>
                Purchase Date: <strong>{{ $purchaseReturn->purchase->purchase_date ?? '-' }}</strong>
            </p>

            <h5 class="card-title mt‑4">Return Information</h5>
            <p class="card-text">
                Return Invoice No: <strong>{{ $purchaseReturn->return_invoice_no ?? '-' }}</strong><br>
                Return Date: <strong>{{ $purchaseReturn->return_date }}</strong><br>
                Quantity Returned: <strong>{{ $purchaseReturn->product_quantity }}</strong><br>
                Refund Amount: <strong>{{ number_format($purchaseReturn->refund_amount,2) }}</strong><br>
                Tax Adjustment: <strong>{{ $purchaseReturn->tax_amount ? number_format($purchaseReturn->tax_amount,2) : '-' }}</strong><br>
                Shipping Adjustment: <strong>{{ $purchaseReturn->shipping_cost_adjustment ? number_format($purchaseReturn->shipping_cost_adjustment,2) : '-' }}</strong><br>
                Net Refund: <strong>{{ number_format($purchaseReturn->net_refund,2) }}</strong><br>
                Payment Method: <strong>{{ $purchaseReturn->payment_method ?? '-' }}</strong><br>
                Status: <strong>{{ ucfirst($purchaseReturn->status) }}</strong><br>
                Note: <em>{{ $purchaseReturn->note ?? 'No note available' }}</em>
            </p>
        </div>
    </div>

    <a href="{{ route('purchase_returns.edit', $purchaseReturn) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('purchase_returns.destroy', $purchaseReturn) }}" method="POST" style="display:inline‑block;" onsubmit="return confirm('Are you sure you want to delete this record?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
