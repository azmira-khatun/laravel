@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $return->id }}</td>
            </tr>
            <tr>
                <th>Purchase Invoice</th>
                <td>{{ $return->purchase->invoice_no ?? '-' }}</td>
            </tr>
            <tr>
                <th>Total Quantity</th>
                <td>{{ $return->total_quantity }}</td>
            </tr>
            <tr>
                <th>Return Quantity</th>
                <td>{{ $return->return_quantity }}</td>
            </tr>
            <tr>
                <th>Subtotal Amount</th>
                <td>{{ $return->subtotal_amount }}</td>
            </tr>
            <tr>
                <th>Tax Amount</th>
                <td>{{ $return->tax_amount }}</td>
            </tr>
            <tr>
                <th>Shipping Cost</th>
                <td>{{ $return->shipping_cost_adjustment }}</td>
            </tr>
            <tr>
                <th>Refund Amount</th>
                <td>{{ $return->refund_amount }}</td>
            </tr>
            <tr>
                <th>Net Refund</th>
                <td>{{ $return->net_refund }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($return->status) }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $return->note }}</td>
            </tr>
        </table>

        <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection