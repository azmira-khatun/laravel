@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Purchase</h2>

        {{-- ✅ Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ Success Message --}}
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('purchasesUpdate', $purchase->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ $purchase->purchase_date }}"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Invoice No</label>
                    <input type="text" name="invoice_no" class="form-control" value="{{ $purchase->invoice_no }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Vendor</label>
                    <select name="vendor_id" class="form-control" required>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $vendor->id == $purchase->vendor_id ? 'selected' : '' }}>
                                {{ $vendor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Reference No</label>
                    <input type="text" name="reference_no" class="form-control" value="{{ $purchase->reference_no }}">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Total Qty</label>
                    <input type="number" name="total_qty" class="form-control" value="{{ $purchase->total_qty }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Subtotal Amount</label>
                    <input type="number" name="subtotal_amount" step="0.01" class="form-control"
                        value="{{ $purchase->subtotal_amount }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Grand Total</label>
                    <input type="number" name="grand_total" step="0.01" class="form-control"
                        value="{{ $purchase->grand_total }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Paid Amount</label>
                    <input type="number" name="paid_amount" step="0.01" class="form-control"
                        value="{{ $purchase->paid_amount }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Due Amount</label>
                    <input type="number" name="due_amount" step="0.01" class="form-control"
                        value="{{ $purchase->due_amount }}" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Payment Status</label>
                    <select name="payment_status" class="form-control" required>
                        <option value="Paid" {{ $purchase->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Due" {{ $purchase->payment_status == 'Due' ? 'selected' : '' }}>Due</option>
                        <option value="Partial" {{ $purchase->payment_status == 'Partial' ? 'selected' : '' }}>Partial
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="Cash" {{ $purchase->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Bank" {{ $purchase->payment_method == 'Bank' ? 'selected' : '' }}>Bank</option>
                        <option value="Mobile" {{ $purchase->payment_method == 'Mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="Cheque" {{ $purchase->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="Other" {{ $purchase->payment_method == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending" {{ $purchase->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Received" {{ $purchase->status == 'Received' ? 'selected' : '' }}>Received</option>
                        <option value="Cancelled" {{ $purchase->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Invoice File</label>
                    <input type="file" name="invoice_file" class="form-control">
                    @if($purchase->invoice_file)
                        <small>Current File: <a href="{{ asset('storage/' . $purchase->invoice_file) }}"
                                target="_blank">View</a></small>
                    @endif
                </div>

                <div class="col-md-12 mb-3">
                    <label>Note</label>
                    <textarea name="note" rows="3" class="form-control">{{ $purchase->note }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Update Purchase</button>
            <a href="{{ route('purchasesIndex') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection