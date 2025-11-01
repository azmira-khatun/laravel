<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseItem;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with('purchase')->latest()->get();
        return view('pages.purchase_return.index', compact('returns'));
    }

    public function create()
    {
        $purchases = Purchase::all();
        return view('purchase_returns.create', compact('purchases'));
    }

    public function fetchPurchaseData(Request $request)
    {
        $purchase = Purchase::with('items')->find($request->purchase_id);

        if (!$purchase) {
            return response()->json(['error' => 'Purchase not found'], 404);
        }

        // মোট Product Quantity হিসাব করা
        $totalQuantity = $purchase->items->sum('quantity');

        return response()->json([
            'total_quantity' => $totalQuantity,
            'subtotal_amount' => $purchase->subtotal_amount,
            'tax_amount' => $purchase->tax_amount,
            'shipping_cost' => $purchase->shipping_cost,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required',
            'return_quantity' => 'required|numeric|min:1',
            'payment_method' => 'required',
            'status' => 'required',
        ]);

        PurchaseReturn::create([
            'purchase_id' => $request->purchase_id,
            'total_quantity' => $request->total_quantity,
            'return_quantity' => $request->return_quantity,
            'subtotal_amount' => $request->subtotal_amount,
            'tax_amount' => $request->tax_amount,
            'shipping_cost_adjustment' => $request->shipping_cost_adjustment,
            'refund_amount' => $request->refund_amount,
            'net_refund' => $request->net_refund,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return created successfully!');
    }

    public function show($id)
    {
        $return = PurchaseReturn::with('purchase')->findOrFail($id);
        return view('pages.purchase_return.show', compact('return'));
    }

    public function edit($id)
    {
        $return = PurchaseReturn::findOrFail($id);
        $purchases = Purchase::all();
        return view('purchase_returns.edit', compact('return', 'purchases'));
    }

    public function update(Request $request, $id)
    {
        $return = PurchaseReturn::findOrFail($id);
        $return->update($request->all());

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return updated successfully!');
    }

    public function destroy($id)
    {
        $return = PurchaseReturn::findOrFail($id);
        $return->delete();

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return deleted successfully!');
    }
}
