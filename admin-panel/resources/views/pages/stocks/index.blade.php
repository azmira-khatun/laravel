@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Stock Movements</h2>
    <a href="{{ route('stocks.create') }}" class="btn btn-success mb-3">+ New Movement</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Stock After</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->id }}</td>
                <td>{{ $stock->product->name ?? $stock->product_name }}</td>
                <td>{{ ucfirst($stock->transaction_type) }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->stock_after }}</td>
                <td>
                    <a href="{{ route('stocks.show', $stock->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('stocks.edit', $stock->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" style="display:inline-block">
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

    {{ $stocks->links() }}
</div>
@endsection
