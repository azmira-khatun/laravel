@extends('master')

@section('content')
<div class="container mt-4">
    <h1>Purchase Details</h1>

    <a href="{{ route('purchasesIndex') }}" class="btn btn-secondary mb-3">← Back to Purchase List</a>

    <div class="card">
        <div class="card-header">
            Invoice: {{ $purchase->invoice_no }}
        </div>
        <div class="card-body">
            <p><strong>Vendor:</strong> {{ $purchase->vendor->name ?? 'N/A' }}</p>
            <p><strong>Purchase Date:</strong> {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y') }}</p>
            <p><strong>Total Qty:</strong> {{ $purchase->total_qty }}</p>
            <p><strong>Subtotal Amount:</strong> {{ number_format($purchase->subtotal_amount, 2) }}</p>
            <p><strong>Discount Amount:</strong> {{ number_format($purchase->discount_amount ?? 0, 2) }}</p>
            <p><strong>Tax Amount:</strong> {{ number_format($purchase->tax_amount ?? 0, 2) }}</p>
            <p><strong>Shipping Cost:</strong> {{ number_format($purchase->shipping_cost ?? 0, 2) }}</p>
            <p><strong>Grand Total:</strong> {{ number_format($purchase->grand_total, 2) }}</p>
            <p><strong>Paid Amount:</strong> {{ number_format($purchase->paid_amount, 2) }}</p>
            <p><strong>Due Amount:</strong> {{ number_format($purchase->due_amount, 2) }}</p>
            <p><strong>Payment Status:</strong> {{ $purchase->payment_status }}</p>
            <p><strong>Payment Method:</strong> {{ $purchase->payment_method }}</p>
            <p><strong>Status:</strong> {{ $purchase->status }}</p>
            <p><strong>Received Date:</strong> {{ $purchase->received_date ? \Carbon\Carbon::parse($purchase->received_date)->format('d-M-Y') : 'N/A' }}</p>
            <p><strong>Invoice File:</strong>
                @if($purchase->invoice_file)
                    <a href="{{ asset('storage/' . $purchase->invoice_file) }}" target="_blank">Download</a>
                @else
                    N/A
                @endif
            </p>
            <p><strong>Note:</strong> {{ $purchase->note ?? '-' }}</p>
        </div>
    </div>
</div>
@endsection
