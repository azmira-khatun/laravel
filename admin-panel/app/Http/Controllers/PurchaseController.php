<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Models\Product;


class PurchaseController extends Controller
{
    // Purchase History
    public function history()
    {
        $purchases = Purchase::with('vendor')->latest()->paginate(10);
        return view('pages.purchases.history', compact('purchases'));
    }

    // Show Create Form
    public function create()
    {
        $vendors = Vendor::all();
        $products = Product::all(); // <-- ekhane product gulo fetch kora holo

        return view('pages.purchases.create', compact('vendors', 'products'));
    }

    // Store Purchase
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'invoice_no' => 'required|unique:purchases,invoice_no',
            'purchase_date' => 'required|date',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $data = $request->all();

        // Calculate subtotal and total cost
        $data['subtotal_amount'] = $data['product_price'] * $data['product_quantity'];
        $data['total_cost'] = $data['subtotal_amount'] + $data['tax_amount'] + $data['shipping_cost'] - $data['discount_amount'];
        $data['due_amount'] = $data['total_cost'] - $data['paid_amount'];

        Purchase::create($data);

        return redirect()->route('purchasesHistory')->with('message', 'Purchase added successfully!');
    }

    // Show Purchase
    public function show(Purchase $purchase)
    {
        return view('pages.purchases.show', compact('purchase'));
    }

    // Edit Purchase
    public function edit(Purchase $purchase)
    {
        $vendors = Vendor::all();
        return view('pages.purchases.edit', compact('purchase', 'vendors'));
    }

    // Update Purchase
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'invoice_no' => 'required|unique:purchases,invoice_no,' . $purchase->id,
            'purchase_date' => 'required|date',
            'product_quantity' => 'required|integer|min:0',
            'product_price' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $data = $request->all();

        // Recalculate totals
        $data['subtotal_amount'] = $data['product_price'] * $data['product_quantity'];
        $data['total_cost'] = $data['subtotal_amount'] + $data['tax_amount'] + $data['shipping_cost'] - $data['discount_amount'];
        $data['due_amount'] = $data['total_cost'] - $data['paid_amount'];

        $purchase->update($data);

        return redirect()->route('purchasesHistory')->with('message', 'Purchase updated successfully!');
    }

    // Delete Purchase
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchasesHistory')->with('message', 'Purchase deleted successfully!');
    }
}
