@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return List</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('purchase_returns.create') }}" class="btn btn-primary mb-3">Add New Return</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Invoice No</th>
                    <th>Return Qty</th>
                    <th>Refund Amount</th>
                    <th>Status</th>
                    <th>Payment Method</th>
                    <th>Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($returns as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->purchase->invoice_no ?? 'N/A' }}</td>
                        <td>{{ $r->product_quantity }}</td>
                        <td>{{ number_format($r->refund_amount, 2) }}</td>
                        <td>
                            <span class="badge 
                                            @if($r->status == 'completed') bg-success 
                                            @elseif($r->status == 'pending') bg-warning 
                                            @else bg-danger @endif">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>
                        <td>{{ $r->payment_method ?? 'N/A' }}</td>
                        <td>{{ $r->note ?? '-' }}</td>
                        <td>
                            <a href="{{ route('purchase_returns.show', $r->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('purchase_returns.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('purchase_returns.destroy', $r->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No purchase returns found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection