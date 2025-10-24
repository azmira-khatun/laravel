@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Purchase Details (ID: {{ $purchase->id }})</h3>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
        <div class="card-body">

            {{-- Purchase Header Info --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Vendor:</strong> {{ $purchase->vendor->name ?? 'N/A' }}</p>
                    <p><strong>Date Recorded:</strong> {{ $purchase->created_at->format('Y-m-d h:i A') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <h4>Total Purchase Amount: {{ number_format($purchase->total_amount, 2) }}</h4>
                    <p>Purchase Date: {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}</p>
                </div>
            </div>

            <hr>

            <h4>Items Purchased</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price (Cost)</th>
                            <th>Sub Total</th>
                            <th>Sale Price</th>
                            <th>M. Date</th>
                            <th>E. Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Assuming $purchase->items is loaded with PurchaseItem models --}}
                        @foreach ($purchase->items as $item)
                            <tr>
                                <td>{{ $item->product->product_name ?? 'Product Not Found' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->sale_price, 2) }}</td>
                                <td>{{ $item->manufacture_date ? \Carbon\Carbon::parse($item->manufacture_date)->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td>{{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection