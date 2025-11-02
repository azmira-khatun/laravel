{{-- resources/views/pages/sales/create.blade.php --}}
@extends('master')

@section('content')
<div class="container mt-4">
    <h2>New Sale</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control">
                <option value="">-- Select Customer --</option>
                @foreach(\App\Models\Customer::all() as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ old('invoice_no') }}" required>
        </div>

        <div class="mb-3">
            <label for="sale_date" class="form-label">Sale Date</label>
            <input type="date" name="sale_date" id="sale_date" class="form-control" value="{{ old('sale_date', date('Y‑m‑d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="sale"       {{ old('type') == 'sale'        ? 'selected' : '' }}>Sale</option>
                <option value="sale_return"{{ old('type') == 'sale_return' ? 'selected' : '' }}>Return</option>
            </select>
        </div>

        <hr>

        <h5>Items</h5>
        <div id="items_container">
            <div class="row mb-2 item-row">
                <div class="col-md-5">
                    <select name="items[0][product_id]" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[0][quantity]" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="items[0][unit_price]" class="form-control" step="0.01" placeholder="Unit Price" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-info mb-3" id="add_item">Add Another Item</button>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" value="{{ old('total_amount', 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save Sale</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        let itemsContainer = document.getElementById('items_container');
        document.getElementById('add_item').addEventListener('click', function(){
            let index = itemsContainer.querySelectorAll('.item-row').length;
            let newRow = document.createElement('div');
            newRow.className = 'row mb-2 item-row';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <select name="items[${index}][product_id]" class="form-control" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="items[${index}][quantity]" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="items[${index}][unit_price]" class="form-control" step="0.01" placeholder="Unit Price" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                </div>`;
            itemsContainer.appendChild(newRow);
        });

        itemsContainer.addEventListener('click', function(event){
            if (event.target.classList.contains('remove-item')){
                let row = event.target.closest('.item-row');
                if (itemsContainer.querySelectorAll('.item-row').length > 1){
                    row.remove();
                }
            }
        });
    });
</script>
@endsection
