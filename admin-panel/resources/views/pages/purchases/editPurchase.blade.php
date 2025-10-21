@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header">
        <h3>Edit Purchase #{{ $purchase->id ?? 'ID' }}</h3>
    </div>
    <div class="card-body">
        {{-- Display Laravel Session Messages (e.g., success or error) --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{--
        FORM ACTION: Route must target the specific purchase ID for update.
        Example: route('purchases.update', $purchase->id)
        --}}
        <form action="{{ route('purchases.update', $purchase->id ?? 1) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for updating resources in Laravel --}}

            {{-- Vendor Selection --}}
            <div class="form-group mb-3">
                <label for="vendor_id" class="form-label">Select Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror"
                    required>
                    <option value="">Select a Vendor</option>
                    {{-- Assuming $vendors and $purchase are passed from the controller --}}
                    @foreach ($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ (old('vendor_id', $purchase->vendor_id ?? '') == $vendor->id) ? 'selected' : '' }}>
                            {{ $vendor->name }}
                        </option>
                    @endforeach
                </select>
                @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <h4 class="mt-4">Product Items</h4>

            <div id="productList">

                {{-- Product Item Loop: Generates a row for each existing item --}}
                @forelse ($purchase->items ?? [(object) ['stock_id' => null]] as $item)
                    <div class="product-row row g-3 border rounded p-3 mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Product Name</label>
                            <select name="product_id[]" class="form-control product-select" required>
                                <option value="">Select a Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ (old('product_id.' . $loop->index, $item->stock->product_id ?? '') == $product->id) ? 'selected' : '' }}>
                                        {{ $product->product_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity[]" class="form-control quantity-input" min="1"
                                value="{{ old('quantity.' . $loop->index, $item->quantity ?? 1) }}" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Unit Price (Purchase)</label>
                            <input type="number" step="0.01" name="unit_price[]" class="form-control unit-price-input"
                                min="0" value="{{ old('unit_price.' . $loop->index, $item->unit_price ?? 0.00) }}" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="number" step="0.01" name="sale_price[]" class="form-control sale-price-input"
                                min="0" value="{{ old('sale_price.' . $loop->index, $item->stock->sale_price ?? 0.00) }}"
                                required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Manufacture Date</label>
                            <input type="date" name="manufacture_date[]" class="form-control manufacture-date-input"
                                value="{{ old('manufacture_date.' . $loop->index, $item->stock->manufacture_date ?? '') }}">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" name="expiry_date[]" class="form-control expiry-date-input"
                                value="{{ old('expiry_date.' . $loop->index, $item->stock->expiry_date ?? '') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end mb-3">
                            <button type="button" class="btn btn-danger remove-product-row w-100">Remove</button>
                        </div>
                    </div>
                @empty
                    {{-- Fallback: If no items exist, insert an empty row structure (optional but safe) --}}
                    {{-- For brevity, the full empty row structure is omitted here, as the JS can handle adding the first
                    row --}}
                @endforelse
            </div>

            <button type="button" id="addProductRowBtn" class="btn btn-secondary mb-3">Add Another Product</button>

            <hr>

            {{-- Total Amount (Read-only, calculated by JS) --}}
            <div class="form-group mb-4">
                <label for="total_amount" class="form-label">Total Amount</label>
                <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control"
                    value="{{ $purchase->total_amount ?? 0.00 }}" readonly required>
                @error('total_amount') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" name="process_purchase" class="btn btn-primary">Update Purchase</button>
        </form>
    </div>
</div>

{{-- JavaScript Section for Dynamic Rows and Calculation --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const productList = document.getElementById('productList');
        const addProductRowBtn = document.getElementById('addProductRowBtn');
        const totalAmountInput = document.getElementById('total_amount');

        // IMPORTANT: We grab the full product list from the first row's options for cloning
        const productOptionsHTML = productList.querySelector('.product-select').innerHTML;

        function createProductRow() {
            const productRow = document.createElement('div');
            productRow.className = 'product-row row g-3 border rounded p-3 mb-3';
            productRow.innerHTML = `
                <div class="col-md-12 mb-3">
                    <label class="form-label">Product Name</label>
                    <select name="product_id[]" class="form-control product-select" required>
                        ${productOptionsHTML}
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="1" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Unit Price (Purchase)</label>
                    <input type="number" step="0.01" name="unit_price[]" class="form-control unit-price-input" min="0" value="0.00" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price[]" class="form-control sale-price-input" min="0" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Manufacture Date</label>
                    <input type="date" name="manufacture_date[]" class="form-control manufacture-date-input">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="date" name="expiry_date[]" class="form-control expiry-date-input">
                </div>
                <div class="col-md-2 d-flex align-items-end mb-3">
                    <button type="button" class="btn btn-danger remove-product-row w-100">Remove</button>
                </div>
            `;
            return productRow;
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-row').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const unitPrice = parseFloat(row.querySelector('.unit-price-input').value) || 0;
                total += quantity * unitPrice;
            });
            totalAmountInput.value = total.toFixed(2);
        }

        // --- Event Listeners ---
        // Calculate total on input change for quantity or unit price
        productList.addEventListener('input', function (e) {
            if (e.target.classList.contains('quantity-input') || e.target.classList.contains('unit-price-input')) {
                calculateTotal();
            }
        });

        // Add new product row
        addProductRowBtn.addEventListener('click', function () {
            const newRow = createProductRow();
            productList.appendChild(newRow);
            calculateTotal();
        });

        // Remove a product row
        productList.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product-row')) {
                if (document.querySelectorAll('.product-row