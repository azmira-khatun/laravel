@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Purchase Return</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('purchase_returns.update', $purchaseReturn->id) }}" method="POST" id="returnForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="purchase_id" class="form-label">Select Purchase</label>
                <select name="purchase_id" id="purchase_id" class="form-control" required>
                    <option value="">-- Select Purchase --</option>
                    @foreach($purchases as $p)
                        <option value="{{ $p->id }}" {{ $p->id == $purchaseReturn->purchase_id ? 'selected' : '' }}>
                            {{ $p->invoice_no }} (ID: {{ $p->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Purchased Quantity</label>
                <input type="text" id="total_quantity" class="form-control" value="{{ $purchaseReturn->product_quantity }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="product_quantity" class="form-label">Return Quantity</label>
                <input type="number" name="product_quantity" id="product_quantity" class="form-control" min="1"
                    value="{{ $purchaseReturn->product_quantity }}" required>
            </div>

            <div class="mb-3">
                <label for="subtotal_amount" class="form-label">Subtotal Amount</label>
                <input type="text" id="subtotal_amount" class="form-control" value="{{ $purchaseReturn->subtotal_amount }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="tax_amount" class="form-label">Tax Amount</label>
                <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control"
                    value="{{ $purchaseReturn->tax_amount }}" readonly>
            </div>

            <div class="mb-3">
                <label for="shipping_cost_adjustment" class="form-label">Shipping Cost</label>
                <input type="number" step="0.01" name="shipping_cost_adjustment" id="shipping_cost_adjustment"
                    class="form-control" value="{{ $purchaseReturn->shipping_cost_adjustment }}" readonly>
            </div>

            <div class="mb-3">
                <label for="refund_amount" class="form-label">Refund Amount</label>
                <input type="number" step="0.01" name="refund_amount" id="refund_amount" class="form-control"
                    value="{{ $purchaseReturn->refund_amount }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Net Refund</label>
                <input type="text" id="net_refund" class="form-control"
                    value="{{ $purchaseReturn->refund_amount - ($purchaseReturn->tax_amount + $purchaseReturn->shipping_cost_adjustment) }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="Cash" {{ $purchaseReturn->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option value="Bank" {{ $purchaseReturn->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                    <option value="Card" {{ $purchaseReturn->payment_method == 'Card' ? 'selected' : '' }}>Card</option>
                    <option value="Mobile Payment" {{ $purchaseReturn->payment_method == 'Mobile Payment' ? 'selected' : '' }}>Mobile Payment</option>
                    <option value="Other" {{ $purchaseReturn->payment_method == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" {{ $purchaseReturn->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $purchaseReturn->status == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ $purchaseReturn->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control" rows="3">{{ $purchaseReturn->note }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Update Return</button>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const purchaseSelect = document.getElementById('purchase_id');
                const subtotalField = document.getElementById('subtotal_amount');
                const taxInput = document.getElementById('tax_amount');
                const shippingInput = document.getElementById('shipping_cost_adjustment');
                const refundInput = document.getElementById('refund_amount');
                const netRefundField = document.getElementById('net_refund');
                const totalQtyField = document.getElementById('total_quantity');
                const returnQtyInput = document.getElementById('product_quantity');

                let totalPurchasedQty = parseFloat(totalQtyField.value) || 1;

                function calculateRefund() {
                    const returnQty = parseFloat(returnQtyInput.value) || 0;
                    const subtotal = parseFloat(subtotalField.value) || 0;
                    const tax = parseFloat(taxInput.value) || 0;
                    const shipping = parseFloat(shippingInput.value) || 0;

                    const refund = (subtotal / totalPurchasedQty) * returnQty;
                    refundInput.value = refund.toFixed(2);

                    const proportionalTax = (tax / totalPurchasedQty) * returnQty;
                    const proportionalShipping = (shipping / totalPurchasedQty) * returnQty;

                    netRefundField.value = (refund - (proportionalTax + proportionalShipping)).toFixed(2);
                }

                returnQtyInput.addEventListener('input', calculateRefund);
            });
        </script>
    @endpush
@endsection