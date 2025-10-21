@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Purchase History</h3>

            {{-- FIX: Changed route('pages.purchases.create') or route('purchases.create') to route('purchaseCreate') --}}
            <a href="{{ route('purchaseCreate') }}" class="btn btn-primary">Add New Purchase</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Purchase Date</th>
                            <th>Vendor</th>
                            <th>Total Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Assuming $purchases variable is passed from the controller's index() method --}}
                        @forelse ($purchases as $purchase)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}</td>
                                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                                <td>{{ number_format($purchase->total_amount, 2) }}</td>
                                <td>
                                    {{-- FIX: Changed route('purchases.show', ...) to route('purchaseShow', ...) --}}
                                    <a href="{{ route('purchaseShow', $purchase->id) }}" class="btn btn-sm btn-info">View
                                        Details</a>

                                    {{-- FIX: Changed route('purchases.edit', ...) to route('purchaseEdit', ...) --}}
                                    <a href="{{ route('purchaseEdit', $purchase->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                    {{-- Delete Form (Requires purchaseDelete route) --}}
                                    <form action="{{ route('purchaseDelete', $purchase->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this purchase?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No purchases recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination links --}}
            {{ $purchases->links() }}
        </div>
    </div>
@endsection