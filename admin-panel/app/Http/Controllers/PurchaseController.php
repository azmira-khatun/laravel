<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // 🧾 Show all purchases (History Page)
    public function history()
    {
        $purchases = Purchase::with('vendor')->orderBy('id', 'desc')->get();
        return view('pages.purchases.historyPurchase', compact('purchases'));
    }

    // ➕ Show create form
    public function create()
    {
        $vendors = Vendor::all();
        return view('pages.purchases.createPurchase', compact('vendors'));
    }

    // 💾 Store new purchase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'invoice_no' => 'required|string|max:50|unique:purchases',
            'vendor_id' => 'required|integer|exists:vendors,id',
            'reference_no' => 'nullable|string|max:100',
            'total_qty' => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_cost' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
            'payment_status' => 'required|in:Paid,Due,Partial',
            'payment_method' => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'received_date' => 'nullable|date',
            'status' => 'required|in:Pending,Received,Cancelled',
            'note' => 'nullable|string',
            'invoice_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // 🧾 File upload handle
        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        // 👤 Add created_by user
        $validated['created_by'] = auth()->id() ?? 1;

        // ✅ Insert into database
        Purchase::create($validated);

        // 🔁 Redirect to History Page
        return redirect()->route('purchasesHistory')->with('message', '✅ Purchase successfully created.');
    }

    // 👁️ Show single purchase
    public function show(Purchase $purchase)
    {
        return view('pages.purchases.viewPurchase', compact('purchase'));
    }

    // ✏️ Show edit form
    public function edit(Purchase $purchase)
    {
        $vendors = Vendor::all();
        return view('pages.purchases.editPurchase', compact('purchase', 'vendors'));
    }

    // ♻️ Update purchase
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'purchase_date' => 'required|date',
            'invoice_no' => 'required|string|max:50|unique:purchases,invoice_no,' . $purchase->id,
            'vendor_id' => 'required|integer|exists:vendors,id',
            'reference_no' => 'nullable|string|max:100',
            'total_qty' => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount' => 'nullable|numeric',
            'shipping_cost' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'due_amount' => 'required|numeric',
            'payment_status' => 'required|in:Paid,Due,Partial',
            'payment_method' => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'received_date' => 'nullable|date',
            'status' => 'required|in:Pending,Received,Cancelled',
            'note' => 'nullable|string',
            'invoice_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // 🧾 File upload update
        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        // ✅ Update record
        $purchase->update($validated);

        // 🔁 Redirect to History Page
        return redirect()->route('purchasesHistory')->with('message', '✅ Purchase updated successfully.');
    }

    // 🗑️ Delete purchase
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchasesHistory')->with('message', '🗑️ Purchase deleted successfully.');
    }
}
