@extends('master')

@section('content')
<div class="container">
    <h1>Purchases List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('purchasesCreate') }}" class="btn btn-primary mb-3">Add New Purchase</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Purchase Date</th>
                <th>Invoice No</th>
                <th>Vendor</th>
                <th>Total Qty</th>
                <th>Grand Total</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y‑m‑d') }}</td>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                    <td>{{ $purchase->total_qty }}</td>
                    <td>{{ number_format($purchase->grand_total, 2) }}</td>
                    <td>{{ number_format($purchase->paid_amount, 2) }}</td>
                    <td>{{ number_format($purchase->due_amount, 2) }}</td>
                    <td>{{ $purchase->payment_status }}</td>
                    <td>{{ $purchase->status }}</td>
                    <td>
                        <a href="{{ route('purchasesShow', $purchase->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('purchasesEdit', $purchase->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('purchasesDelete', $purchase->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
