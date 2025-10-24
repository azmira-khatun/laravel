@extends('master')

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            <h3>Create New Purchase</h3>
        </div>
        <div class="card-body">
            {{-- Display Laravel Session Messages (e.g., success or error) --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('purchaseStore') }}" method="POST">
                @csrf {{-- Laravel security token --}}

                {{-- Vendor Selection --}}
                <div class="form-group mb-3">
                    <label for="vendor_id" class="form-label">Select Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="form-control @error('vendor_id') is-invalid @enderror"
                        required>
                        <option value="">Select a Vendor</option>
                        {{-- Assuming $vendors is passed from the controller --}}
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <h4 class="mt-4">Product Items</h4>

                <div id="productList">
                    {{-- Initial Product Row (start with one, clone with JS) --}}
                    <div class="product-row row g-3 border rounded p-3 mb-3">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Product Name</label>
                            <select name="product_id[]" class="form-control product-select" required>
                                <option value="">Select a Product</option>
                                {{-- Assuming $products is passed from the controller --}}
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="1"
                                required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price[]" class="form-control unit-price-input"
                                min="0" value="0.00" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Sale Price</label>
                            <input type="number" step="0.01" name="sale_price[]" class="form-control sale-price-input"
                                min="0" required>
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
                    </div>
                </div>

                <button type="button" id="addProductRowBtn" class="btn btn-secondary mb-3">Add Another Product</button>

                <hr>

                {{-- Total Amount (Read-only, calculated by JS) --}}
                <div class="form-group mb-4">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" value="0.00"
                        readonly required>
                    @error('total_amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <button type="submit" name="process_purchase" class="btn btn-primary">Process Purchase</button>
            </form>
        </div>
    </div>

    {{-- JavaScript Section for Dynamic Rows and Calculation --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productList = document.getElementById('productList');
            const addProductRowBtn = document.getElementById('addProductRowBtn');
            const totalAmountInput = document.getElementById('total_amount');

            // Capture the HTML of the first row's product options for cloning
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
                                            <label class="form-label">Unit Price</label>
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

            productList.addEventListener('input', function (e) {
                if (e.target.classList.contains('quantity-input') || e.target.classList.contains('unit-price-input')) {
                    calculateTotal();
                }
            });

            addProductRowBtn.addEventListener('click', function () {
                const newRow = createProductRow();
                productList.appendChild(newRow);
                calculateTotal();
            });

            productList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-product-row')) {
                    // Ensure at least one product row remains
                    if (document.querySelectorAll('.product-row').length > 1) {
                        e.target.closest('.product-row').remove();
                        calculateTotal();
                    } else {
                        alert("You must have at least one product in the purchase.");
                    }
                }
            });

            calculateTotal(); // Initial calculation on page load.
        });
    </script>@push('scripts')

    @endpush
@endsection