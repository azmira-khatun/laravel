@extends('master')

@section('content')
<div class="container">
    <h1>Stock List</h1>
    <a href="{{ route('stockCreate') }}" class="btn btn-primary mb-3">Add New Stock</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>User</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
                <tr>
                    <td>{{ $stock->id }}</td>
                    <td>{{ $stock->product_id }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ optional($stock->user)->name ?? '-' }}</td>
                    <td>{{ $stock->created_at->format('Y‑m‑d H:i') }}</td>
                    <td>{{ $stock->updated_at->format('Y‑m‑d H:i') }}</td>
                    <td>
                        <a href="{{ route('stockEdit', $stock->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('stockDelete', $stock->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- যদি pagination ব্যবহার করেন -->
    {{ $stocks->links() }}
</div>
@endsection
