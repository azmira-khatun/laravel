<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // Purchase History
    public function history()
    {
        // vendor এবং product উভয় সম্পর্কসহ লোড করা
        $purchases = Purchase::with(['vendor', 'product'])
                             ->latest()
                             ->paginate(10);

        return view('pages.purchases.history', compact('purchases'));
    }

    // Show Create Form
    public function create()
    {
        $vendors  = Vendor::all();
        $products = Product::all();

        return view('pages.purchases.create', compact('vendors', 'products'));
    }

    // Store Purchase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id'        => 'required|exists:vendors,id',
            'product_id'       => 'required|exists:products,id',
            'invoice_no'       => 'required|unique:purchases,invoice_no',
            'purchase_date'    => 'required|date',
            'product_quantity' => 'required|integer|min:1',
            'product_price'    => 'required|numeric|min:0',
            'paid_amount'      => 'required|numeric|min:0',
            'discount_amount'  => 'nullable|numeric|min:0',
            'tax_amount'       => 'nullable|numeric|min:0',
            'shipping_cost'    => 'nullable|numeric|min:0',
            'payment_status'   => 'required|string|in:pending,paid,partial',
            'payment_method'   => 'required|string|max:50',
            'receive_date'     => 'nullable|date',
            'note'             => 'nullable|string',
            'status'           => 'required|string|in:active,cancelled',
        ]);

        // হিসাব করা হচ্ছে
        $validated['subtotal_amount'] = $validated['product_price'] * $validated['product_quantity'];
        $validated['total_cost']      = $validated['subtotal_amount']
                                        + ($validated['tax_amount']   ?? 0)
                                        + ($validated['shipping_cost'] ?? 0)
                                        - ($validated['discount_amount'] ?? 0);
        $validated['due_amount'] = $validated['total_cost'] - $validated['paid_amount'];

        Purchase::create($validated);

        return redirect()->route('purchasesHistory')
                         ->with('message', 'Purchase added successfully!');
    }

    // Show Purchase
    public function show(Purchase $purchase)
    {
        // vendor ও product লোড আছে যদি না থাকে
        $purchase->load(['vendor', 'product']);

        return view('pages.purchases.show', compact('purchase'));
    }

    // Edit Purchase
    public function edit(Purchase $purchase)
    {
        $vendors  = Vendor::all();
        $products = Product::all();

        return view('pages.purchases.edit', compact('purchase', 'vendors', 'products'));
    }

    // Update Purchase
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'vendor_id'        => 'required|exists:vendors,id',
            'product_id'       => 'required|exists:products,id',
            'invoice_no'       => 'required|unique:purchases,invoice_no,' . $purchase->id,
            'purchase_date'    => 'required|date',
            'product_quantity' => 'required|integer|min:1',
            'product_price'    => 'required|numeric|min:0',
            'paid_amount'      => 'required|numeric|min:0',
            'discount_amount'  => 'nullable|numeric|min:0',
            'tax_amount'       => 'nullable|numeric|min:0',
            'shipping_cost'    => 'nullable|numeric|min:0',
            'payment_status'   => 'required|string|in:pending,paid,partial',
            'payment_method'   => 'required|string|max:50',
            'receive_date'     => 'nullable|date',
            'note'             => 'nullable|string',
            'status'           => 'required|string|in:active,cancelled',
        ]);

        // রি‑হিসাব
        $validated['subtotal_amount'] = $validated['product_price'] * $validated['product_quantity'];
        $validated['total_cost']      = $validated['subtotal_amount']
                                        + ($validated['tax_amount']   ?? 0)
                                        + ($validated['shipping_cost'] ?? 0)
                                        - ($validated['discount_amount'] ?? 0);
        $validated['due_amount'] = $validated['total_cost'] - $validated['paid_amount'];

        $purchase->update($validated);

        return redirect()->route('purchasesHistory')
                         ->with('message', 'Purchase updated successfully!');
    }

    // Delete Purchase
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return redirect()->route('purchasesHistory')
                         ->with('message', 'Purchase deleted successfully!');
    }
}
