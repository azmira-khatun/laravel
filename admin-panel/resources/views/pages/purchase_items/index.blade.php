@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Purchase Items</h2>
                <a class="btn btn-success btn-sm" href="{{ route('purchaseItems.create') }}">Add New Item</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Purchase</th>
                            <th>Product</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Purchased Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseItems as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->purchase->invoice_no ?? '-' }}</td>
                                <td>{{ $item->product->name ?? '-' }}</td>
                                <td>{{ $item->unit->name ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                                <td>{{ $item->purchased_date->format('Y-m-d') }}</td>
                                <td>
                                    <a class="btn btn-info btn-sm mb-1"
                                        href="{{ route('purchaseItems.show', $item->id) }}">View</a>
                                    <a class="btn btn-primary btn-sm mb-1"
                                        href="{{ route('purchaseItems.edit', $item->id) }}">Edit</a>
                                    <form action="{{ route('purchaseItems.delete', $item->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-1"
                                            onclick="return confirm('Are you sure you want to delete this item?')">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        @if($purchaseItems->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center">No purchase items found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection