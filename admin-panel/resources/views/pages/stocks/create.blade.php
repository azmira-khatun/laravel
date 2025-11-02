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
            <label for="product_id">Select Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="transaction_type">Transaction Type</label>
            <select name="transaction_type" id="transaction_type" class="form-control" required>
                <option value="purchase">Purchase</option>
                <option value="purchase_return">Purchase Return</option>
                <option value="sale">Sale</option>
                <option value="sale_return">Sale Return</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" required>
        </div>

        <div class="mb-3">
            <label for="note">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control" rows="2"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
