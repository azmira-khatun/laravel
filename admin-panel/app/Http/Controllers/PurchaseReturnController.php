<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    /**
     * Show all purchase returns.
     */
    public function index()
    {
        $returns = PurchaseReturn::with('purchase')->latest()->get();
        return view('pages.purchase_return.index', compact('returns'));
    }

    /**
     * Show form for creating new return.
     */
    public function create()
    {
        $purchases = Purchase::select('id', 'invoice_no')->get();
        return view('pages.purchase_return.create', compact('purchases'));
    }

    /**
     * Store a new purchase return.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,cancelled',
            'note' => 'nullable|string',
        ]);

        PurchaseReturn::create($validated);

        return redirect()->route('purchase_returns.index')
            ->with('success', 'Purchase return created successfully.');
    }

    /**
     * Show a specific return.
     */
    public function show(PurchaseReturn $purchaseReturn)
    {
        return view('pages.purchase_return.show', compact('purchaseReturn'));
    }

    /**
     * Edit existing return.
     */
    public function edit(PurchaseReturn $purchaseReturn)
    {
        $purchases = Purchase::select('id', 'invoice_no')->get();
        return view('pages.purchase_return.edit', compact('purchaseReturn', 'purchases'));
    }

    /**
     * Update existing purchase return.
     */
    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_quantity' => 'required|integer|min:1',
            'refund_amount' => 'required|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'shipping_cost_adjustment' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|max:50',
            'status' => 'required|in:pending,completed,cancelled',
            'note' => 'nullable|string',
        ]);

        $purchaseReturn->update($validated);

        return redirect()->route('purchase_returns.index')
            ->with('success', 'Purchase return updated successfully.');
    }

    /**
     * Delete a return.
     */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->delete();
        return redirect()->route('purchase_returns.index')
            ->with('success', 'Purchase return deleted successfully.');
    }

    /**
     * AJAX – Fetch purchase data for auto-fill & refund calculation.
     */
    public function fetchPurchaseData(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
        ]);

        $purchase = Purchase::with('items')->find($request->purchase_id);

        if (!$purchase) {
            return response()->json(['error' => 'Purchase not found'], 404);
        }

        // Safely calculate total quantity
        $totalQuantity = $purchase->items ? $purchase->items->sum('quantity') : 0;

        return response()->json([
            'subtotal_amount' => (float) $purchase->subtotal_amount,
            'tax_amount' => (float) $purchase->tax_amount,
            'shipping_cost' => (float) $purchase->shipping_cost,
            'total_quantity' => (int) $totalQuantity,
        ]);
    }
}
