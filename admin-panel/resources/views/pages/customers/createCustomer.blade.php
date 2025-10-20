@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Customers</h2>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        {{-- Name Field --}}
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        {{-- Email Field --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        {{-- Address Field --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>

        {{-- Contact Field --}}
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact">
        </div>

        <button type="submit" class="btn btn-primary">Save Customer</button>
    </form>
</div>
@endsection
