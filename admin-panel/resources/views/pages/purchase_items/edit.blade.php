@extends('master')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Purchase Item</h2>
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

        <form action="{{ route('purchase-items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Purchase ID</label>
                <input type="number" name="purchase_id" class="form-control" value="{{ old('purchase_id', $item->purchase_id) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Product ID</label>
                <input type="number" name="product_id" class="form-control" value="{{ old('product_id', $item->product_id) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Unit ID</label>
                <input type="number" name="unit_id" class="form-control" value="{{ old('unit_id', $item->unit_id) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="text" name="quantity" class="form-control" value="{{ old('quantity', $item->quantity) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Unit Price</label>
                <input type="text" name="unit_price" class="form-control" value="{{ old('unit_price', $item->unit_price) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Purchased Date</label>
                <input type="date" name="purchased_date" class="form-control" value="{{ old('purchased_date', $item->purchased_date->format('Y-m-d')) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
