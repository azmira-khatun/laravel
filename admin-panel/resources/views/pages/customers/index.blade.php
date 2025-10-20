@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Customer List</h3>
        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Add New Customer</a>
    </div>
    <div class="card-body">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}">{{ $customer->name }}</a>
                    </td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->contact }}</td>
                    <td>{{ Str::limit($customer->address, 30) }}</td>
                    <td>
                        {{-- Edit Button --}}
                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        {{-- Delete Button --}}
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ $customer->name }}?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No customers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
