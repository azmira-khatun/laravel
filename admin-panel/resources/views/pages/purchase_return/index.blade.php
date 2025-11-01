@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>All Purchase Returns</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('purchase_returns.create') }}" class="btn btn-success mb-3">Add New Return</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Purchase Invoice</th>
                    <th>Return Quantity</th>
                    <th>Refund Amount</th>
                    <th>Net Refund</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($returns as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->purchase->invoice_no ?? '' }}</td>
                        <td>{{ $r->product_quantity }}</td>
                        <td>{{ $r->refund_amount }}</td>
                        <td>{{ $r->refund_amount - ($r->tax_amount + $r->shipping_cost_adjustment) }}</td>
                        <td>{{ ucfirst($r->status) }}</td>
                        <td>
                            <a href="{{ route('purchase_returns.show', $r->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('purchase_returns.edit', $r->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('purchase_returns.destroy', $r->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure to delete?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection