@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        {{-- ধরে নেওয়া হচ্ছে $vendor ভেরিয়েবলটি কন্ট্রোলার থেকে আসছে --}}
        <h3>Vendor Details: {{ $vendor->name }}</h3>
        <a href="{{ route('vendors.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            {{-- 1. Name --}}
            <div class="col-md-6 mb-3">
                <p><strong>Vendor Name:</strong></p>
                <p class="form-control-plaintext">{{ $vendor->name }}</p>
            </div>

            {{-- 2. Email --}}
            <div class="col-md-6 mb-3">
                <p><strong>Email:</strong></p>
                <p class="form-control-plaintext">{{ $vendor->email ?? 'N/A' }}</p>
            </div>

            {{-- 3. Phone --}}
            <div class="col-md-6 mb-3">
                <p><strong>Phone Number:</strong></p>
                <p class="form-control-plaintext">{{ $vendor->phone ?? 'N/A' }}</p>
            </div>

            {{-- 4. TIN Number --}}
            <div class="col-md-6 mb-3">
                <p><strong>TIN Number (Tax ID):</strong></p>
                <p class="form-control-plaintext">{{ $vendor->tin_number ?? 'N/A' }}</p>
            </div>
        </div>

        <hr>

        {{-- 5. Address (Full Width) --}}
        <div class="row">
            <div class="col-12 mb-3">
                <p><strong>Address:</strong></p>
                <p class="form-control-plaintext">{{ $vendor->address ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- 6. Bank Details (Full Width) --}}
        <div class="row">
            <div class="col-12 mb-3">
                <p><strong>Bank Details:</strong></p>
                <p class="form-control-plaintext">{{ $vendor->bank_details ?? 'N/A' }}</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6">
                <p class="text-muted">Created At: {{ $vendor->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div class="col-md-6">
                <p class="text-muted">Last Updated: {{ $vendor->updated_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>

        {{-- Edit এবং Delete বাটন --}}
        <div class="mt-4">
            <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-warning">Edit Vendor</a>

            {{-- Delete Form --}}
            <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this vendor?');">Delete Vendor</button>
            </form>
        </div>
    </div>
</div>
@endsection
