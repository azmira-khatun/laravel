@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Add New Purchase</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchasesStore') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="vendor_id" class="form-label">Vendor</label>
            <select name="vendor_id" id="vendor_id" class="form-control" required>
                <option value="">Select Vendor</option>
                @foreach($vendors as $vendor)
                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" name="invoice_no" id="invoice_no" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="purchase_date" class="form-label">Purchase Date</label>
            <input type="date" name="purchase_date" id="purchase_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="product_quantity" class="form-label">Product Quantity</label>
            <input type="number" name="product_quantity" id="product_quantity" class="form-control" value="0" min="1" required>
        </div>

        <div class="mb-3">
            <label for="subtotal_amount" class="form-label">Subtotal Amount</label>
            <input type="number" name="subtotal_amount" id="subtotal_amount" class="form-control" value="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="discount_amount" class="form-label">Discount Amount</label>
            <input type="number" name="discount_amount" id="discount_amount" class="form-control" value="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="product_price" class="form-label">Product Price (Auto Calculated)</label>
            <input type="number" name="product_price" id="product_price" class="form-control" value="0" step="0.01" readonly>
        </div>

        <div class="mb-3">
            <label for="tax_amount" class="form-label">Tax Amount</label>
            <input type="number" name="tax_amount" id="tax_amount" class="form-control" value="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="shipping_cost" class="form-label">Shipping Cost</label>
            <input type="number" name="shipping_cost" id="shipping_cost" class="form-control" value="0" step="0.01">
        </div>

        <div class="mb-3">
            <label for="total_cost" class="form-label">Total Cost (Auto Calculated)</label>
            <input type="number" name="total_cost" id="total_cost" class="form-control" value="0" step="0.01" readonly>
        </div>

        <div class="mb-3">
            <label for="paid_amount" class="form-label">Paid Amount</label>
            <input type="number" name="paid_amount" id="paid_amount" class="form-control" value="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="due_amount" class="form-label">Due Amount</label>
            <input type="number" name="due_amount" id="due_amount" class="form-control" value="0" step="0.01" readonly>
        </div>

        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="partial">Partial</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control">
        </div>

        <div class="mb-3">
            <label for="receive_date" class="form-label">Receive Date</label>
            <input type="date" name="receive_date" id="receive_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active">Active</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save Purchase</button>
    </form>
</div>

<script>
function calculateProductPriceTotalDue() {
    let quantity = parseFloat(document.getElementById('product_quantity').value) || 0;
    let subtotal = parseFloat(document.getElementById('subtotal_amount').value) || 0;
    let discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    let shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;

    // product_price
    let productPrice = 0;
    if(quantity > 0){
        productPrice = (subtotal - discount) / quantity;
    }
    document.getElementById('product_price').value = productPrice.toFixed(2);

    // total_cost
    let totalCost = (productPrice * quantity) + tax + shipping - discount;
    document.getElementById('total_cost').value = totalCost.toFixed(2);

    // due_amount
    let due = totalCost - paid;
    document.getElementById('due_amount').value = due.toFixed(2);
}

// লিসেনার যোগ করা
['product_quantity','subtotal_amount','discount_amount','tax_amount','shipping_cost','paid_amount'].forEach(id => {
    document.getElementById(id).addEventListener('input', calculateProductPriceTotalDue);
});
</script>
@endsection
