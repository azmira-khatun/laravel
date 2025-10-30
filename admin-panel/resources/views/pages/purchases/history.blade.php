@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Purchase History</h2>

    <a href="{{ route('purchasesCreate') }}" class="btn btn-success mb-3">Add New Purchase</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vendor</th>
                <th>Invoice No</th>
                <th>Purchase Date</th>
                <th>Total Cost</th>
                <th>Paid Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->id }}</td>
                <td>{{ $purchase->vendor->name }}</td>
                <td>{{ $purchase->invoice_no }}</td>
                <td>{{ $purchase->purchase_date }}</td>
                <td>{{ number_format($purchase->total_cost,2) }}</td>
                <td>{{ number_format($purchase->paid_amount,2) }}</td>
                <td>{{ number_format($purchase->due_amount,2) }}</td>
                <td>{{ ucfirst($purchase->payment_status) }}</td>
                <td>
                    <a href="{{ route('purchasesShow', $purchase) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('purchasesEdit', $purchase) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('purchasesDelete', $purchase) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
