@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Purchase Return</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('purchase_returns.update', $purchaseReturn->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Select Purchase</label>
                <select name="purchase_id" class="form-control" required>
                    <option value="">-- Select Purchase --</option>
                    @foreach($purchases as $p)
                        <option value="{{ $p->id }}" {{ $purchaseReturn->purchase_id == $p->id ? 'selected' : '' }}>
                            {{ $p->invoice_no }} (ID: {{ $p->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Return Quantity</label>
                <input type="number" name="product_quantity" class="form-control"
                    value="{{ $purchaseReturn->product_quantity }}" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Refund Amount</label>
                <input type="text" name="refund_amount" class="form-control"
                    value="{{ number_format($purchaseReturn->refund_amount, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Tax Amount</label>
                <input type="text" name="tax_amount" class="form-control"
                    value="{{ number_format($purchaseReturn->tax_amount, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Shipping Cost</label>
                <input type="text" name="shipping_cost_adjustment" class="form-control"
                    value="{{ number_format($purchaseReturn->shipping_cost_adjustment, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Method</label>
                <select name="payment_method" class="form-control">
                    <option value="">-- Select --</option>
                    <option value="Cash" {{ $purchaseReturn->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Bank" {{ $purchaseReturn->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                    <option value="Card" {{ $purchaseReturn->payment_method == 'Card' ? 'selected' : '' }}>Card</option>
                    <option value="Mobile Payment" {{ $purchaseReturn->payment_method == 'Mobile Payment' ? 'selected' : '' }}>Mobile Payment</option>
                    <option value="Other" {{ $purchaseReturn->payment_method == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $purchaseReturn->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $purchaseReturn->status == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ $purchaseReturn->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Note</label>
                <textarea name="note" class="form-control" rows="3">{{ $purchaseReturn->note }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update Return</button>
        </form>
    </div>
@endsection