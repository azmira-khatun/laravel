@extends('master')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Add New Purchase Item</h2>
        <a class="btn btn-secondary btn-sm" href="{{ route('purchase-items.index') }}">Back</a>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('purchase-items.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="purchase_id" class="form-label">Purchase ID</label>
                <input type="number" name="purchase_id" class="form-control" value="{{ old('purchase_id') }}" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Product ID</label>
                <input type="number" name="product_id" class="form-control" value="{{ old('product_id') }}" required>
            </div>
            <div class="mb-3">
                <label for="unit_id" class="form-label">Unit ID</label>
                <input type="number" name="unit_id" class="form-control" value="{{ old('unit_id') }}" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" name="quantity" class="form-control" value="{{ old('quantity') }}" required>
            </div>
            <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price</label>
                <input type="text" name="unit_price" class="form-control" value="{{ old('unit_price') }}" required>
            </div>
            <div class="mb-3">
                <label for="purchased_date" class="form-label">Purchased Date</label>
                <input type="date" name="purchased_date" class="form-control" value="{{ old('purchased_date') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
