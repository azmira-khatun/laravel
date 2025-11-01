@extends('master')

@section('content')
<div class="container mt-4">
    <h2>New Stock Movement</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product_name"
                   class="form-control" value="{{ old('product_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="transaction_type" class="form-label">Transaction Type</label>
            <select name="transaction_type" id="transaction_type" class="form-control" required>
                <option value="">-- Select Type --</option>
                <option value="purchase"       {{ old('transaction_type')=='purchase'        ? 'selected' : '' }}>Purchase</option>
                <option value="sale"           {{ old('transaction_type')=='sale'            ? 'selected' : '' }}>Sale</option>
                <option value="purchase_return"{{ old('transaction_type')=='purchase_return'? 'selected' : '' }}>Purchase Return</option>
                <option value="sale_return"    {{ old('transaction_type')=='sale_return'    ? 'selected' : '' }}>Sale Return</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control"
                   value="{{ old('quantity', 1) }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="unit_cost" class="form-label">Unit Cost</label>
            <input type="number" name="unit_cost" id="unit_cost" class="form-control"
                   value="{{ old('unit_cost') }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="unit_price" class="form-label">Unit Price</label>
            <input type="number" name="unit_price" id="unit_price" class="form-control"
                   value="{{ old('unit_price') }}" step="0.01">
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
