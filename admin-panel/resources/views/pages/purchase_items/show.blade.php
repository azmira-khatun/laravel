@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Purchase Item Details</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $item->id }}</td>
                    </tr>
                    <tr>
                        <th>Purchase</th>
                        <td>{{ $item->purchase->invoice_no ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Product</th>
                        <td>{{ $item->product->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Unit</th>
                        <td>{{ $item->unit->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Unit Price</th>
                        <td>{{ number_format($item->unit_price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Price</th>
                        <td>{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Purchased Date</th>
                        <td>{{ $item->purchased_date->format('Y-m-d') }}</td>
                    </tr>
                </table>
                <a href="{{ route('purchaseItems.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection