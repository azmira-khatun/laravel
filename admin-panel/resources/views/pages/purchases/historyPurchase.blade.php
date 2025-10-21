@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Purchase History Details (ID: {{ $purchase->id ?? 'N/A' }})</h3>
            {{-- Link back to the main list --}}
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
        <div class="card-body">

            {{-- 1. General Purchase Information --}}
            <h4>General Information</h4>
            <table class="table table-bordered mb-4">
                <tbody>
                    <tr>
                        <th style="width: 25%;">Vendor Name</th>
                        <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Purchase Date</th>
                        <td>{{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d H:i:s') : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total Purchase Amount</th>
                        <td>**{{ number_format($purchase->total_amount ?? 0, 2) }}**</td>
                    </tr>
                </tbody>
            </table>

            {{-- 2. Itemized Product Breakdown --}}
            <h4>Purchased Items Breakdown</h4>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Purchase Price</th>
                            <th>Subtotal</th>
                            <th>Current Sale Price</th>
                            <th>Manufacture/Expiry</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through the items related to this purchase --}}
                        @forelse($purchase->items ?? [] as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->stock->product->product_name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->stock->sale_price ?? 0, 2) }}</td>
                                <td>
                                    Mfg: {{ $item->stock->manufacture_date ?? 'N/A' }}<br>
                                    Exp: **{{ $item->stock->expiry_date ?? 'N/A' }}**
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No items recorded for this purchase history.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection