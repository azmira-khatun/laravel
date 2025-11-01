@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return List</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('purchase_returns.create') }}" class="btn btn-primary mb-3">+ New Return</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Purchase Invoice</th>
                    <th>Total Qty</th>
                    <th>Return Qty</th>
                    <th>Refund</th>
                    <th>Net Refund</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($returns as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->purchase->invoice_no ?? '-' }}</td>
                        <td>{{ $r->total_quantity }}</td>
                        <td>{{ $r->return_quantity }}</td>
                        <td>{{ $r->refund_amount }}</td>
                        <td>{{ $r->net_refund }}</td>
                        <td>{{ ucfirst($r->status) }}</td>
                        <td>
                            <a href="{{ route('purchase_returns.show', $r->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('purchase_returns.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('purchase_returns.destroy', $r->id) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this return?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection