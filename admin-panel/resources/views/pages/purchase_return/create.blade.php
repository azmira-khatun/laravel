@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Create Purchase Return</h2>

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

        <form action="{{ route('purchase_returns.store') }}" method="POST" id="returnForm">
            @csrf

            <div class="mb-3">
                <label for="purchase_id" class="form-label">Select Purchase</label>
                <select name="purchase_id" id="purchase_id" class="form-control" required>
                    <option value="">-- Select Purchase --</option>
                    @foreach($purchases as $p)
                        <option value="{{ $p->id }}">{{ $p->invoice_no }} (ID: {{ $p->id }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Total Purchased Quantity</label>
                <input type="text" id="total_quantity" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="product_quantity" class="form-label">Return Quantity</label>
                <input type="number" name="product_quantity" id="product_quantity" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label for="subtotal_amount" class="form-label">Subtotal Amount</label>
                <input type="text" id="subtotal_amount" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="tax_amount" class="form-label">Tax Amount</label>
                <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" value="0" readonly>
            </div>

            <div class="mb-3">
                <label for="shipping_cost_adjustment" class="form-label">Shipping Cost</label>
                <input type="number" step="0.01" name="shipping_cost_adjustment" id="shipping_cost_adjustment"
                    class="form-control" value="0" readonly>
            </div>

            <div class="mb-3">
                <label for="refund_amount" class="form-label">Refund Amount</label>
                <input type="number" step="0.01" name="refund_amount" id="refund_amount" class="form-control" value="0"
                    readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Net Refund</label>
                <input type="text" id="net_refund" class="form-control" value="0.00" readonly>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                    <option value="Card">Card</option>
                    <option value="Mobile Payment">Mobile Payment</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Submit Return</button>
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

                let totalPurchasedQty = 1; // avoid division by zero

                purchaseSelect.addEventListener('change', function () {
                    const pid = this.value;
                    if (!pid) return;

                    fetch("{{ route('purchase_returns.fetch_purchase_data') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ purchase_id: pid })
                    })
                        .then(response => response.json())
                        .then(data => {
                            subtotalField.value = (data.subtotal_amount || 0).toFixed(2);
                            taxInput.value = (data.tax_amount || 0).toFixed(2);
                            shippingInput.value = (data.shipping_cost || 0).toFixed(2);
                            totalPurchasedQty = data.total_quantity || 1;
                            totalQtyField.value = totalPurchasedQty;
                            calculateRefund();
                        })
                        .catch(err => {
                            console.error(err);
                            subtotalField.value = 0;
                            taxInput.value = 0;
                            shippingInput.value = 0;
                            totalQtyField.value = 0;
                            totalPurchasedQty = 1;
                            calculateRefund();
                        });
                });

                function calculateRefund() {
                    const returnQty = parseFloat(returnQtyInput.value) || 0;
                    const subtotal = parseFloat(subtotalField.value) || 0;
                    const tax = parseFloat(taxInput.value) || 0;
                    const shipping = parseFloat(shippingInput.value) || 0;

                    // proportional refund
                    const refund = (subtotal / totalPurchasedQty) * returnQty;
                    refundInput.value = refund.toFixed(2);

                    // proportional tax & shipping
                    const proportionalTax = (tax / totalPurchasedQty) * returnQty;
                    const proportionalShipping = (shipping / totalPurchasedQty) * returnQty;

                    // net refund
                    const netRefund = refund - (proportionalTax + proportionalShipping);
                    netRefundField.value = netRefund.toFixed(2);
                }

                returnQtyInput.addEventListener('input', calculateRefund);
            });
        </script>
    @endpush

@endsection