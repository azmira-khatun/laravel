@extends('master')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Purchase Items</h2>
        <a class="btn btn-success btn-sm" href="{{ route('purchase-items.create') }}">Add New Item</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
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
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->purchase->id ?? '' }}</td>
                    <td>{{ $item->product->name ?? '' }}</td>
                    <td>{{ $item->unit->name ?? '' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->unit_price }}</td>
                    <td>{{ $item->total_price }}</td>
                    <td>{{ $item->purchased_date->format('Y-m-d') }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('purchase-items.show', $item->id) }}">View</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('purchase-items.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('purchase-items.destroy', $item->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                              onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
