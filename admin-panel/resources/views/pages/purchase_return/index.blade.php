@extends('master')

@section('content')
<div class="container mt‑4">
    <h1>Purchase Returns List</h1>
    <a href="{{ route('purchase_returns.create') }}" class="btn btn-primary mb‑3">Add New Return</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Purchase Invoice No</th>
                <th>Return Date</th>
                <th>Refund Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($returns as $return)
            <tr>
                <td>{{ $return->id }}</td>
                <td>{{ $return->purchase->invoice_no ?? '-' }}</td>
                <td>{{ $return->return_date }}</td>
                <td>{{ number_format($return->refund_amount,2) }}</td>
                <td>{{ ucfirst($return->status) }}</td>
                <td>
                    <a href="{{ route('purchase_returns.show', $return) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('purchase_returns.edit', $return) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('purchase_returns.destroy', $return) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
