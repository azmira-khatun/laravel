@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Purchase Details</h2>

    <a href="{{ route('purchasesHistory') }}" class="btn btn-secondary mb-3">Back to History</a>
    <a href="{{ route('purchasesEdit', $purchase) }}" class="btn btn-warning mb-3">Edit Purchase</a>

    <table class="table table-bordered">
        <tr><th>ID</th><td>{{ $purchase->id }}</td></tr>
        <tr><th>Vendor</th><td>{{ $purchase->vendor->name }}</td></tr>
        <tr><th>Invoice No</th><td>{{ $purchase->invoice_no }}</td></tr>
        <tr><th>Purchase Date</th><td>{{ $purchase->purchase_date }}</td></tr>
        <tr><th>Product Quantity</th><td>{{ $purchase->product_quantity }}</td></tr>
        <tr><th>Product Price</th><td>{{ number_format($purchase->product_price,2) }}</td></tr>
        <tr><th>Subtotal Amount</th><td>{{ number_format($purchase->subtotal_amount,2) }}</td></tr>
        <tr><th>Tax Amount</th><td>{{ number_format($purchase->tax_amount,2) }}</td></tr>
        <tr><th>Shipping Cost</th><td>{{ number_format($purchase->shipping_cost,2) }}</td></tr>
        <tr><th>Discount Amount</th><td>{{ number_format($purchase->discount_amount,2) }}</td></tr>
        <tr><th>Total Cost</th><td>{{ number_format($purchase->total_cost,2) }}</td></tr>
        <tr><th>Paid Amount</th><td>{{ number_format($purchase->paid_amount,2) }}</td></tr>
        <tr><th>Due Amount</th><td>{{ number_format($purchase->due_amount,2) }}</td></tr>
        <tr><th>Payment Status</th><td>{{ ucfirst($purchase->payment_status) }}</td></tr>
        <tr><th>Payment Method</th><td>{{ $purchase->payment_method }}</td></tr>
        <tr><th>Receive Date</th><td>{{ $purchase->receive_date ?? '-' }}</td></tr>
        <tr><th>Note</th><td>{{ $purchase->note ?? '-' }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($purchase->status) }}</td></tr>
        <tr><th>Created At</th><td>{{ $purchase->created_at }}</td></tr>
        <tr><th>Updated At</th><td>{{ $purchase->updated_at }}</td></tr>
    </table>
</div>
@endsection
