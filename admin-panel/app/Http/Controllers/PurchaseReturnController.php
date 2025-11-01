<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with(['purchase', 'vendor'])->latest()->get();
        return view('purchase_returns.index', compact('returns'));
    }

    public function create()
    {
        $purchases = Purchase::select('id','invoice_no','tax_amount','shipping_cost','subtotal_amount')->get();
        return view('purchase_returns.create', compact('purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id'              => 'required|exists:purchases,id',
            'return_date'              => 'required|date',
            'product_quantity'         => 'required|integer|min:1',
            'refund_amount'            => 'required|numeric|min:0',
            'tax_amount'               => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method'           => 'nullable|string|max:255',
            'status'                   => 'required|in:pending,completed,cancelled',
            'note'                     => 'nullable|string',
        ]);

        PurchaseReturn::create($request->all());

        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return created successfully.');
    }

    public function show(PurchaseReturn $purchaseReturn)
    {
        return view('purchase_returns.show', compact('purchaseReturn'));
    }

    public function edit(PurchaseReturn $purchaseReturn)
    {
        $purchases = Purchase::select('id','invoice_no','tax_amount','shipping_cost','subtotal_amount')->get();
        return view('purchase_returns.edit', compact('purchaseReturn', 'purchases'));
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $request->validate([
            'purchase_id'              => 'required|exists:purchases,id',
            'return_date'              => 'required|date',
            'product_quantity'         => 'required|integer|min:1',
            'refund_amount'            => 'required|numeric|min:0',
            'tax_amount'               => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method'           => 'nullable|string|max:255',
            'status'                   => 'required|in:pending,completed,cancelled',
            'note'                     => 'nullable|string',
        ]);

        $purchaseReturn->update($request->all());

        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return updated successfully.');
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->delete();
        return redirect()->route('purchase_returns.index')
                         ->with('success', 'Purchase return deleted successfully.');
    }

    /** AJAX fetch purchase data */
    public function fetchPurchaseData(Request $request)
    {
        $purchase = Purchase::select('tax_amount','shipping_cost','subtotal_amount')
                     ->find($request->purchase_id);

        if (!$purchase) {
            return response()->json(['error'=>'Purchase not found'], 404);
        }

        return response()->json([
            'tax_amount'      => $purchase->tax_amount,
            'shipping_cost'   => $purchase->shipping_cost,
            'subtotal_amount' => $purchase->subtotal_amount,
        ]);
    }
}
