@extends('layouts.app')

@section('content')
<div class="container mt‑4">
    <h1>Edit Purchase Return (ID: {{ $purchaseReturn->id }})</h1>

    <form action="{{ route('purchase_returns.update', $purchaseReturn) }}" method="POST" id="returnForm">
        @csrf
        @method('PUT')

        <div class="mb‑3">
            <label for="purchase_id" class="form-label">Select Purchase</label>
            <select name="purchase_id" id="purchase_id" class="form-control" required>
                @foreach($purchases as $p)
                    <option value="{{ $p->id }}"
                        {{ $purchaseReturn->purchase_id == $p->id ? 'selected' : '' }}>
                        {{ $p->invoice_no }} (ID:{{ $p->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb‑3">
            <label class="form-label">Subtotal Amount</label>
            <input type="text" id="subtotal_amount" class="form-control" readonly
                   value="{{ number_format($purchaseReturn->purchase->subtotal_amount ?? 0,2) }}">
        </div>

        <div class="mb‑3">
            <label for="tax_amount" class="form-label">Tax Amount</label>
            <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control"
                   value="{{ $purchaseReturn->tax_amount ?? 0 }}">
        </div>

        <div class="mb‑3">
            <label for="shipping_cost_adjustment" class="form-label">Shipping Cost</label>
            <input type="number" step="0.01" name="shipping_cost_adjustment" id="shipping_cost_adjustment" class="form-control"
                   value="{{ $purchaseReturn->shipping_cost_adjustment ?? 0 }}">
        </div>

        <div class="mb‑3">
            <label for="refund_amount" class="form-label">Refund Amount</label>
            <input type="number" step="0.01" name="refund_amount" id="refund_amount" class="form-control"
                   value="{{ $purchaseReturn->refund_amount }}" required>
        </div>

        <div class="mb‑3">
            <label class="form-label">Net Refund</label>
            <input type="text" id="net_refund" class="form-control" readonly
                   value="{{ number_format($purchaseReturn->net_refund,2) }}">
        </div>

        <div class="mb‑3">
            <label for="product_quantity" class="form-label">Product Quantity</label>
            <input type="number" name="product_quantity" id="product_quantity" class="form-control"
                   value="{{ $purchaseReturn->product_quantity }}" min="1" required>
        </div>

        <div class="mb‑3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control"
                   value="{{ $purchaseReturn->payment_method }}">
        </div>

        <div class="mb‑3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending"   {{ $purchaseReturn->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $purchaseReturn->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $purchaseReturn->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb‑3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control" rows="3">{{ $purchaseReturn->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const purchaseSelect = document.getElementById('purchase_id');
        const subtotalField  = document.getElementById('subtotal_amount');
        const taxInput       = document.getElementById('tax_amount');
        const shippingInput  = document.getElementById('shipping_cost_adjustment');
        const refundInput    = document.getElementById('refund_amount');
        const netRefundField = document.getElementById('net_refund');

        purchaseSelect.addEventListener('change', function(){
            const pid = this.value;
            if(pid){
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
                    subtotalField.value  = (data.subtotal_amount || 0).toFixed(2);
                    taxInput.value       = data.tax_amount      || 0;
                    shippingInput.value  = data.shipping_cost   || 0;
                    calculateNetRefund();
                })
                .catch(error => {
                    console.error('Error:', error);
                    subtotalField.value  = "";
                    taxInput.value       = 0;
                    shippingInput.value  = 0;
                    calculateNetRefund();
                });
            }
        });

        function calculateNetRefund(){
            const refund   = parseFloat(refundInput.value)       || 0;
            const tax      = parseFloat(taxInput.value)          || 0;
            const shipping = parseFloat(shippingInput.value)     || 0;
            const netRefund= refund - (tax + shipping);
            netRefundField.value = netRefund.toFixed(2);
        }

        refundInput.addEventListener('input', calculateNetRefund);
        taxInput.addEventListener('input', calculateNetRefund);
        shippingInput.addEventListener('input', calculateNetRefund);

    });
</script>
@endpush

@endsection
