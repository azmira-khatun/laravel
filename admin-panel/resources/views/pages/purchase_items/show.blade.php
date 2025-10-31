@extends('master')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Purchase Item Details</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('purchase-items.index') }}">Back</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>ID</th><td>{{ $item->id }}</td></tr>
            <tr><th>Purchase ID</th><td>{{ $item->purchase_id }}</td></tr>
            <tr><th>Product ID</th><td>{{ $item->product_id }}</td></tr>
            <tr><th>Unit ID</th><td>{{ $item->unit_id }}</td></tr>
            <tr><th>Quantity</th><td>{{ $item->quantity }}</td></tr>
            <tr><th>Unit Price</th><td>{{ $item->unit_price }}</td></tr>
            <tr><th>Total Price</th><td>{{ $item->total_price }}</td></tr>
            <tr><th>Purchased Date</th><td>{{ $item->purchased_date->format('Y-m-d') }}</td></tr>
            <tr><th>Created At</th><td>{{ $item->created_at }}</td></tr>
            <tr><th>Updated At</th><td>{{ $item->updated_at }}</td></tr>
        </table>
    </div>
</div>
@endsection
