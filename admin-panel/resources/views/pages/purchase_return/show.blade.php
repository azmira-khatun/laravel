@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>Purchase Invoice</th>
                <td>{{ $purchaseReturn->purchase->invoice_no ?? '' }}</td>
            </tr>
            <tr>
                <th>Return Quantity</th>
                <td>{{ $purchaseReturn->product_quantity }}</td>
            </tr>
            <tr>
                <th>Subtotal Amount</th>
                <td>{{ $purchaseReturn->subtotal_amount }}</td>
            </tr>
            <tr>
                <th>Tax Amount</th>
                <td>{{ $purchaseReturn->tax_amount }}</td>
            </tr>
            <tr>
                <th>Shipping Cost</th>
                <td>{{ $purchaseReturn->shipping_cost_adjustment }}</td>
            </tr>
            <tr>
                <th>Refund Amount</th>
                <td>{{ $purchaseReturn->refund_amount }}</td>
            </tr>
            <tr>
                <th>Net Refund</th>
                <td>{{ $purchaseReturn->refund_amount - ($purchaseReturn->tax_amount + $purchaseReturn->shipping_cost_adjustment) }}
                </td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ $purchaseReturn->payment_method }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $purchaseReturn->status }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $purchaseReturn->note }}</td>
            </tr>
        </table>

        <a href="{{ route('purchase_returns.index') }}" class="btn btn-primary">Back to List</a>
    </div>
@endsection