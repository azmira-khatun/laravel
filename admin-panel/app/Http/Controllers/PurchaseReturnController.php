<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with('purchase')->latest()->get();
        return view('pages.purchase_return.index', compact('returns'));
    }

    public function create()
    {
        $purchases = Purchase::select('id', 'invoice_no', 'tax_amount', 'shipping_cost', 'subtotal_amount')->get();
        return view('pages.purchase_return.create', compact('purchases'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_date' => 'required|date',
            'product_quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:pending,completed,cancelled',
            'note' => 'nullable|string',
        ]);

        PurchaseReturn::create($validated);

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return created successfully.');
    }

    public function show(PurchaseReturn $purchaseReturn)
    {
        return view('pages.purchase_return.show', compact('purchaseReturn'));
    }

    public function edit(PurchaseReturn $purchaseReturn)
    {
        $purchases = Purchase::select('id', 'invoice_no', 'tax_amount', 'shipping_cost', 'subtotal_amount')->get();
        return view('pages.purchase_return.edit', compact('purchaseReturn', 'purchases'));
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'return_date' => 'required|date',
            'product_quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:pending,completed,cancelled',
            'note' => 'nullable|string',
        ]);

        $purchaseReturn->update($validated);

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return updated successfully.');
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->delete();
        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return deleted successfully.');
    }

    // AJAX fetch purchase data for proportional calculation
    public function fetchPurchaseData(Request $request)
    {
        $request->validate(['purchase_id' => 'required|exists:purchases,id']);

        $purchase = Purchase::select('subtotal_amount', 'tax_amount', 'shipping_cost')->find($request->purchase_id);

        if (!$purchase) {
            return response()->json(['error' => 'Purchase not found'], 404);
        }

        return response()->json([
            'subtotal_amount' => $purchase->subtotal_amount,
            'tax_amount' => $purchase->tax_amount,
            'shipping_cost' => $purchase->shipping_cost,
        ]);
    }
}
