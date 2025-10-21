@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Purchase List</h3>
            {{-- Link to the Create Purchase Page --}}
            <a href="{{ route('purchases.create') }}" class="btn btn-primary">Add New Purchase</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vendor Name</th>
                            <th>Purchase Date</th>
                            <th>Total Amount</th>
                            <th>Items Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Assuming $purchases is passed from the controller --}}
                        @forelse($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                <td>{{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') : 'N/A' }}
                                </td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>{{ $purchase->items->count() ?? 0 }}</td>
                                <td>
                                    {{-- View Details Button --}}
                                    <a href="{{ route('purchases.show', $purchase->id) }}"
                                        class="btn btn-sm btn-info me-2">View</a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('purchases.edit', $purchase->id) }}"
                                        class="btn btn-sm btn-warning me-2">Edit</a>

                                    {{-- Delete Form (Requires confirmation in production) --}}
                                    <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this purchase?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No purchases found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Optional: Pagination Links --}}
            {{-- {{ $purchases->links() }} --}}

        </div>
    </div>
@endsection