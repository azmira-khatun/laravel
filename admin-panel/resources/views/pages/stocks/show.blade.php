@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Stock Movement Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $stock->id }}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td>{{ $stock->product->name ?? $stock->product_name }}</td>
            </tr>
            <tr>
                <th>Transaction Type</th>
                <td>{{ ucfirst($stock->transaction_type) }}</td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td>{{ $stock->quantity }}</td>
            </tr>
            <tr>
                <th>Stock After</th>
                <td>{{ $stock->stock_after }}</td>
            </tr>
            <tr>
                <th>Vendor</th>
                <td>{{ $stock->vendor->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>{{ $stock->customer->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Unit Cost</th>
                <td>{{ number_format($stock->unit_cost,2) }}</td>
            </tr>
            <tr>
                <th>Unit Price</th>
                <td>{{ number_format($stock->unit_price,2) }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $stock->note }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $stock->movement_date ? $stock->movement_date->format('Y‑m‑d H:i') : $stock->created_at->format('Y‑m‑d H:i') }}</td>
            </tr>
        </table>

        <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Back to list</a>
    </div>
@endsection
