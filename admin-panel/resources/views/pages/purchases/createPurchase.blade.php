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

        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <form action="{{ route('purchasesStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Invoice No</label>
                    <input type="text" name="invoice_no" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Vendor</label>
                    <select name="vendor_id" class="form-control" required>
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Reference No</label>
                    <input type="text" name="reference_no" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Total Qty</label>
                    <input type="number" name="total_qty" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Subtotal Amount</label>
                    <input type="number" name="subtotal_amount" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Grand Total</label>
                    <input type="number" name="grand_total" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Paid Amount</label>
                    <input type="number" name="paid_amount" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Due Amount</label>
                    <input type="number" name="due_amount" step="0.01" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Payment Status</label>
                    <select name="payment_status" class="form-control" required>
                        <option value="Paid">Paid</option>
                        <option value="Due">Due</option>
                        <option value="Partial">Partial</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="Cash">Cash</option>
                        <option value="Bank">Bank</option>
                        <option value="Mobile">Mobile</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending">Pending</option>
                        <option value="Received">Received</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Invoice File</label>
                    <input type="file" name="invoice_file" class="form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Note</label>
                    <textarea name="note" rows="3" class="form-control"></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save Purchase</button>
            <a href="{{ route('purchasesHistory') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection