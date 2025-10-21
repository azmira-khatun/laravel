@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3>Edit Purchase #{{ $purchase->id }}</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Required for UPDATE action --}}

                {{-- Vendor Selection (Read-only or disabled for consistency) --}}
                <div class="form-group mb-3">
                    <label for="vendor_id" class="form-label">Select Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="form-control" disabled>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $purchase->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- Send the ID via a hidden field since the select is disabled --}}
                    <input type="hidden" name="vendor_id" value="{{ $purchase->vendor_id }}">
                </div>

                <h4 class="mt-4">Product Items</h4>

                <div id="productList">
                    {{-- Loop through existing items to populate the form --}}
                    @foreach ($purchase->items as $item)
                        <div class="product-row row g-3 border rounded p-3 mb-3">
                            <input type="hidden" name="item_id[]" value="{{ $item->id }}"> {{-- Item ID to identify for update
                            --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Product Name</label>
                                <select name="product_id[]" class="form-control product-select" required>
                                    <option value="">Select a Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity[]" class="form-control quantity-input" min="1"
                                    value="{{ old('quantity.' . $loop->index, $item->quantity) }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Unit Price</label>
                                <input type="number" step="0.01" name="unit_price[]" class="form-control unit-price-input"
                                    min="0" value="{{ old('unit_price.' . $loop->index, $item->unit_price) }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Sale Price</label>
                                <input type="number" step="0.01" name="sale_price[]" class="form-control sale-price-input"
                                    min="0" value="{{ old('sale_price.' . $loop->index, $item->sale_price) }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Manufacture Date</label>
                                <input type="date" name="manufacture_date[]" class="form-control manufacture-date-input"
                                    value="{{ old('manufacture_date.' . $loop->index, optional($item->manufacture_date)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date[]" class="form-control expiry-date-input"
                                    value="{{ old('expiry_date.' . $loop->index, optional($item->expiry_date)->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end mb-3">
                                <button type="button" class="btn btn-danger remove-product-row w-100">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="addProductRowBtn" class="btn btn-secondary mb-3">Add Another Product</button>

                <hr>

                {{-- Total Amount (Read-only, calculated by JS) --}}
                <div class="form-group mb-4">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control"
                        value="{{ old('total_amount', $purchase->total_amount) }}" readonly required>
                    @error('total_amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-success">Update Purchase</button>
            </form>
        </div>
    </div>
    {{-- Include your JavaScript section (from createPurchase) here as well --}}
@endsection