@extends('layouts.app')
{{-- নিশ্চিত করুন যে এটি আপনার সঠিক মাস্টার লেআউট ফাইল --}}

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create New Purchase</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">New Purchase</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Purchase Details</h3>
                </div>

                {{-- Form for Purchase --}}
                <form action="{{ route('purchase.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- General Purchase Info (Vendor and Date) --}}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="vendor_id">Select Vendor</label>
                                {{-- Vendor list should be passed from the Controller --}}
                                <select name="vendor_id" id="vendor_id" class="form-control select2" style="width: 100%;"
                                    required>
                                    <option value="">Select a Vendor</option>
                                    {{-- STATIC EXAMPLE: Replace with Blade loop using $vendors array --}}
                                    {{-- @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach --}}
                                    <option value="1">Vendor A (Static)</option>
                                    <option value="2">Vendor B (Static)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        {{-- Product Items Section --}}
                        <h4 class="mt-4 mb-3">Product Items</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="purchase_items_table">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Product Name</th>
                                        <th style="width: 10%">Quantity</th>
                                        <th style="width: 15%">Unit Cost</th>
                                        <th style="width: 15%">Sale Price</th>
                                        <th style="width: 15%">MFD Date</th>
                                        <th style="width: 15%">EXD Date</th>
                                        <th style="width: 5%">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Item Row Template --}}
                                    @include('purchase.purchase_item_row', ['i' => 0, 'products' => []])
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-right"><strong>TOTAL AMOUNT</strong></td>
                                        <td>
                                            <input type="text" name="total_amount" id="total_amount" class="form-control"
                                                value="0.00" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button type="button" id="add_item_row_btn" class="btn btn-sm btn-success mt-2"><i
                                class="fas fa-plus"></i> Add Another Product</button>
                    </div>

                    <div class="card-footer">
                        <button type="submit" name="process_purchase" class="btn btn-primary">Process Purchase</button>
                        <a href="{{ url('/dashboard') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection