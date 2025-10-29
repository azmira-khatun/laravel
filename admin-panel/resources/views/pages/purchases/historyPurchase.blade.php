@extends('master')

@section('content')
<div class="container mt-4">
    <h1>Purchase History</h1>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <a href="{{ route('purchasesCreate') }}" class="btn btn-primary mb-3">Add New Purchase</a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Invoice No</th>
                <th>Vendor</th>
                <th>Purchase Date</th>
                <th>Grand Total</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ $purchase->invoice_no }}</td>
                    <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d-M-Y') }}</td>
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
            @empty
                <tr>
                    <td colspan="10" class="text-center">No purchase history found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
