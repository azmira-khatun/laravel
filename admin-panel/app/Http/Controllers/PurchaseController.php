<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display all purchases (history view).
     */
    public function history()
    {
        $purchases = Purchase::with(['vendor', 'user', 'product', 'productUnit', 'paymentMethod'])
                              ->orderBy('purchase_date', 'desc')
                              ->get();

        return view('pages.purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new purchase.
     */
    public function create()
    {
        // You should pass dropdown data here (vendors, products, units, payment methods)
        return view('pages.purchases.create');
    }

    /**
     * Store a newly created purchase in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id'         => 'required|integer|exists:vendors,id',
            'user_id'           => 'nullable|integer|exists:users,id',
            'product_id'        => 'required|integer|exists:products,id|unique:purchases,product_id',
            'subtotal_amount'   => 'required|numeric',
            'productunit_id'    => 'required|integer|exists:product_units,id',
            'discount_amount'   => 'nullable|numeric',
            'tax_amount'        => 'nullable|numeric',
            'shipping_cost'     => 'nullable|numeric',
            'total_cost'        => 'required|numeric',
            'paid_amount'       => 'nullable|numeric',
            'due_amount'        => 'required|numeric',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'payment_status'    => 'required|string|max:100',
            'purchase_date'     => 'nullable|date',
            'receive_date'      => 'nullable|date',
        ]);

        Purchase::create($data);

        return redirect()->route('purchases.history')
                         ->with('success', 'Purchase successfully created.');
    }

    /**
     * Display the specified purchase.
     */
    public function show(Purchase $purchase)
    {
        $purchase->load(['vendor', 'user', 'product', 'productUnit', 'paymentMethod']);

        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified purchase.
     */
    public function edit(Purchase $purchase)
    {
        // Pass the purchase and dropdown data to the view
        return view('purchases.edit', compact('purchase'));
    }

    /**
     * Update the specified purchase in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $data = $request->validate([
            'vendor_id'         => 'required|integer|exists:vendors,id',
            'user_id'           => 'nullable|integer|exists:users,id',
            'product_id'        => 'required|integer|exists:products,id|unique:purchases,product_id,'.$purchase->id,
            'subtotal_amount'   => 'required|numeric',
            'productunit_id'    => 'required|integer|exists:product_units,id',
            'discount_amount'   => 'nullable|numeric',
            'tax_amount'        => 'nullable|numeric',
            'shipping_cost'     => 'nullable|numeric',
            'total_cost'        => 'required|numeric',
            'paid_amount'       => 'nullable|numeric',
            'due_amount'        => 'required|numeric',
            'payment_method_id' => 'required|integer|exists:payment_methods,id',
            'payment_status'    => 'required|string|max:100',
            'purchase_date'     => 'nullable|date',
            'receive_date'      => 'nullable|date',
        ]);

        $purchase->update($data);

        return redirect()->route('purchases.history')
                         ->with('success', 'Purchase successfully updated.');
    }

    /**
     * Remove the specified purchase from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchases.history')
                         ->with('success', 'Purchase successfully deleted.');
    }
}
