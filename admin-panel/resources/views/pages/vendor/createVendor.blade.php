@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header">
        <h3>Add New Vendor</h3>
    </div>
    <div class="card-body">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        {{-- Form Action: 'vendorStore' নামে একটি POST route ধরে নেওয়া হচ্ছে --}}
        <form method="POST" action="{{ route('vendorStore') }}" enctype="multipart/form-data">
            @csrf

            {{-- 1. Vendor Name Field --}}
            <div class="form-group mb-3">
                <label for="name">Vendor Name *</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" placeholder="Enter vendor name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 2. Email Field --}}
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="Enter email address">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 3. Phone Field --}}
            <div class="form-group mb-3">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone') }}" placeholder="Enter phone number">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 4. Address Field --}}
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <textarea name="address" id="address"
                          class="form-control @error('address') is-invalid @enderror"
                          rows="3" placeholder="Enter complete address">{{ old('address') }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr> {{-- ব্যবসায়িক তথ্যের জন্য একটি সেপারেটর --}}

            {{-- 5. TIN Number Field (ব্যবসায়িক তথ্য) --}}
            <div class="form-group mb-3">
                <label for="tin_number">TIN Number (Tax ID)</label>
                <input type="text" name="tin_number" id="tin_number"
                       class="form-control @error('tin_number') is-invalid @enderror"
                       value="{{ old('tin_number') }}" placeholder="Enter TIN or Tax ID">
                @error('tin_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- 6. Bank Details Field (ব্যবসায়িক তথ্য) --}}
            <div class="form-group mb-3">
                <label for="bank_details">Bank Details</label>
                <textarea name="bank_details" id="bank_details"
                          class="form-control @error('bank_details') is-invalid @enderror"
                          rows="3" placeholder="Enter bank name, account number, etc.">{{ old('bank_details') }}</textarea>
                @error('bank_details')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Vendor</button>
        </form>
    </div>
</div>
@endsection
