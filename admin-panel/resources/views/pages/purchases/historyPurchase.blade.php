@extends('master')

@section('content')
    <div class="container mt-4">
        <h1>Purchase History</h1>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <a href="{{ route('purchasesCreate') }}" class="btn btn-primary mb-3">Add New Purchase</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Purchase Date</th>
                    <th>Invoice No</th>
                    <th>Vendor</th>
                    <th>Total Qty</th>
                    <th>Grand Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>{{ $purchase->invoice_no }}</td>
                        <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                        <td>{{ $purchase->total_qty }}</td>
                        <td>{{ number_format($purchase->grand_total, 2) }}</td>
                        <td>{{ number_format($purchase->paid_amount, 2) }}</td>
                        <td>{{ number_format($purchase->due_amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                            @if($purchase->status == 'Pending') bg-warning
                                            @elseif($purchase->status == 'Received') bg-success
                                            @else bg-danger @endif">
                                {{ $purchase->status }}
                            </span>
                        </td>
                        <td>{{ $purchase->payment_status }}</td>
                        <td>
                            <a href="{{ route('purchasesShow', $purchase->id) }}" class="btn btn-sm btn-secondary">View</a>
                            <a href="{{ route('purchasesEdit', $purchase->id) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('purchasesDelete', $purchase->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')"
                                    class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted">No purchases found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection