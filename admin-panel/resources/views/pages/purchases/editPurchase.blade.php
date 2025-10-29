@extends('master')

@section('content')
<div class="container">
    <h1>Edit Purchase</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="purchase_date" class="form-label">Purchase Date</label>
            <input type="date" name="purchase_date" class="form-control" id="purchase_date"
                   value="{{ old('purchase_date', $purchase->purchase_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" name="invoice_no" class="form-control" id="invoice_no"
                   value="{{ old('invoice_no', $purchase->invoice_no) }}" required>
        </div>

        <div class="mb-3">
            <label for="vendor_id" class="form-label">Vendor</label>
            <select name="vendor_id" id="vendor_id" class="form-control" required>
                <option value="">Select Vendor</option>
                @foreach(\App\Models\Vendor::all() as $vendor)
                    <option value="{{ $vendor->id }}"
                        {{ old('vendor_id', $purchase->vendor_id) == $vendor->id ? 'selected' : '' }}>
                        {{ $vendor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="reference_no" class="form-label">Reference No (Optional)</label>
            <input type="text" name="reference_no" class="form-control" id="reference_no"
                   value="{{ old('reference_no', $purchase->reference_no) }}">
        </div>

        <div class="mb-3">
            <label for="total_qty" class="form-label">Total Qty</label>
            <input type="number" name="total_qty" class="form-control" id="total_qty"
                   value="{{ old('total_qty', $purchase->total_qty) }}" required>
        </div>

        <div class="mb-3">
            <label for="subtotal_amount" class="form-label">Subtotal Amount</label>
            <input type="text" name="subtotal_amount" class="form-control" id="subtotal_amount"
                   value="{{ old('subtotal_amount', $purchase->subtotal_amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="discount_amount" class="form-label">Discount Amount (Optional)</label>
            <input type="text" name="discount_amount" class="form-control" id="discount_amount"
                   value="{{ old('discount_amount', $purchase->discount_amount) }}">
        </div>

        <div class="mb-3">
            <label for="tax_amount" class="form-label">Tax Amount (Optional)</label>
            <input type="text" name="tax_amount" class="form-control" id="tax_amount"
                   value="{{ old('tax_amount', $purchase->tax_amount) }}">
        </div>

        <div class="mb-3">
            <label for="shipping_cost" class="form-label">Shipping Cost (Optional)</label>
            <input type="text" name="shipping_cost" class="form-control" id="shipping_cost"
                   value="{{ old('shipping_cost', $purchase->shipping_cost) }}">
        </div>

        <div class="mb‑3">
            <label for="grand_total" class="form-label">Grand Total</label>
            <input type="text" name="grand_total" class="form-control" id="grand_total"
                   value="{{ old('grand_total', $purchase->grand_total) }}" required>
        </div>

        <div class="mb‑3">
            <label for="paid_amount" class="form-label">Paid Amount</label>
            <input type="text" name="paid_amount" class="form-control" id="paid_amount"
                   value="{{ old('paid_amount', $purchase->paid_amount) }}" required>
        </div>

        <div class="mb‑3">
            <label for="due_amount" class="form-label">Due Amount</label>
            <input type="text" name="due_amount" class="form-control" id="due_amount"
                   value="{{ old('due_amount', $purchase->due_amount) }}" required>
        </div>

        <div class="mb‑3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control" required>
                <option value="Paid" {{ old('payment_status', $purchase->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Due" {{ old('payment_status', $purchase->payment_status) == 'Due' ? 'selected' : '' }}>Due</option>
                <option value="Partial" {{ old('payment_status', $purchase->payment_status) == 'Partial' ? 'selected' : '' }}>Partial</option>
            </select>
        </div>

        <div class="mb‑3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="Cash" {{ old('payment_method', $purchase->payment_method) == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Bank" {{ old('payment_method', $purchase->payment_method) == 'Bank' ? 'selected' : '' }}>Bank</option>
                <option value="Mobile" {{ old('payment_method', $purchase->payment_method) == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                <option value="Cheque" {{ old('payment_method', $purchase->payment_method) == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                <option value="Other" {{ old('payment_method', $purchase->payment_method) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="mb‑3">
            <label for="received_date" class="form-label">Received Date (Optional)</label>
            <input type="date" name="received_date" class="form-control" id="received_date"
                   value="{{ old('received_date', $purchase->received_date) }}">
        </div>

        <div class="mb‑3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Pending" {{ old('status', $purchase->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Received" {{ old('status', $purchase->status) == 'Received' ? 'selected' : '' }}>Received</option>
                <option value="Cancelled" {{ old('status', $purchase->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb‑3">
            <label for="invoice_file" class="form-label">Invoice File (Optional)</label>
            @if($purchase->invoice_file)
                <p>Existing File: <a href="{{ Storage::url($purchase->invoice_file) }}" target="_blank">View</a></p>
            @endif
            <input type="file" name="invoice_file" class="form-control" id="invoice_file">
        </div>

        <div class="mb‑3">
            <label for="note" class="form-label">Note (Optional)</label>
            <textarea name="note" class="form-control" id="note">{{ old('note', $purchase->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
