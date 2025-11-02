@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Edit Stock Movement</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('stocks.update', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_id" class="form-label">Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                            {{ $product->id == old('product_id', $stock->product_id) ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="transaction_type" class="form-label">Transaction Type</label>
            <select name="transaction_type" id="transaction_type" class="form-control" required>
                <option value="purchase"       {{ old('transaction_type', $stock->transaction_type)=='purchase'        ? 'selected':'' }}>Purchase</option>
                <option value="purchase_return"{{ old('transaction_type', $stock->transaction_type)=='purchase_return' ? 'selected':'' }}>Purchase Return</option>
                <option value="sale"           {{ old('transaction_type', $stock->transaction_type)=='sale'           ? 'selected':'' }}>Sale</option>
                <option value="sale_return"    {{ old('transaction_type', $stock->transaction_type)=='sale_return'    ? 'selected':'' }}>Sale Return</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $stock->quantity) }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control" rows="2">{{ old('note', $stock->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
