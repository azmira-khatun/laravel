@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h2>Edit Purchase Item</h2>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('purchaseItems.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="purchase_id">Purchase</label>
                        <select name="purchase_id" id="purchase_id" class="form-control" required>
                            @foreach($purchases as $purchase)
                                <option value="{{ $purchase->id }}" {{ $item->purchase_id == $purchase->id ? 'selected' : '' }}>
                                    {{ $purchase->invoice_no }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_id">Product</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control" required>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ $item->unit_id == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" step="0.01" name="quantity" id="quantity" class="form-control"
                            value="{{ $item->quantity }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="unit_price">Unit Price</label>
                        <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control"
                            value="{{ $item->unit_price }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="purchased_date">Purchased Date</label>
                        <input type="date" name="purchased_date" id="purchased_date" class="form-control"
                            value="{{ $item->purchased_date->format('Y-m-d') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('purchaseItems.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection