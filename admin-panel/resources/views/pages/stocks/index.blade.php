@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Stock Movements</h2>
        <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">New Movement</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Stock After</th>
                    <th>Vendor</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $st)
                    <tr>
                        <td>{{ $st->id }}</td>
                        <td>{{ $st->product_name }}</td>
                        <td>{{ ucfirst($st->transaction_type) }}</td>
                        <td>{{ $st->quantity }}</td>
                        <td>{{ $st->stock_after }}</td>
                        <td>{{ $st->vendor->name ?? '-' }}</td>
                        <td>{{ $st->customer->name ?? '-' }}</td>
                        <td>{{ $st->created_at->format('Y‑m‑d') }}</td>
                        <td>
                            <a href="{{ route('stocks.show', $st->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('stocks.edit', $st->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('stocks.destroy', $st->id) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center">No movements found</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $stocks->links() }}
    </div>
@endsection
