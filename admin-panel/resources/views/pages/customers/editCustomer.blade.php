@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Customer: {{ $customer->name }}</h2>

    {{-- The action will point to the update method in your controller --}}
    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Name Field (pre-filled with current data) --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            {{-- 'old()' helper retains data on validation error, otherwise uses current data --}}
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $customer->name) }}" required>
        </div>

        {{-- Email Field (pre-filled with current data) --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
        </div>

        {{-- Address Field (pre-filled with current data) --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
        </div>

        {{-- Contact Field (pre-filled with current data) --}}
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="{{ old('contact', $customer->contact) }}">
        </div>

        <button type="submit" class="btn btn-success">Update Customer</button>
        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
