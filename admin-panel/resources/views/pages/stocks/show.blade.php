@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Stock Movement Details</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>ID</th><td>{{ $stock->id }}</td></tr>
        <tr><th>Product</th><td>{{ $stock->product->name ?? $stock->product_name }}</td></tr>
        <tr><th>Transaction Type</th><td>{{ ucfirst($stock->transaction_type) }}</td></tr>
        <tr><th>Quantity</th><td>{{ $stock->quantity }}</td></tr>
        <tr><th>Stock After</th><td>{{ $stock->stock_after }}</td></tr>
        <tr><th>Note</th><td>{{ $stock->note ?? '-' }}</td></tr>
        <tr><th>Date</th><td>{{ $stock->movement_date }}</td></tr>
    </table>

    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
