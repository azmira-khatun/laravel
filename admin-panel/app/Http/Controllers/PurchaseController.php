<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // 🟢 Show all purchases
    public function index()
    {
        $purchases = Purchase::with('vendor')->orderBy('id', 'desc')->get();
        return view('pages.purchases.historyPurchase', compact('purchases'));
    }

    // 🟢 Show create form
    public function create()
    {
        $vendors = Vendor::all();
        return view('pages.purchases.createPurchase', compact('vendors'));
    }

    // 🟢 Store new purchase
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date'   => 'required|date',
            'invoice_no'      => 'required|string|max:50|unique:purchases',
            'vendor_id'       => 'required|integer|exists:vendors,id',
            'reference_no'    => 'nullable|string|max:100',
            'total_qty'       => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount'      => 'nullable|numeric',
            'shipping_cost'   => 'nullable|numeric',
            'grand_total'     => 'required|numeric',
            'paid_amount'     => 'required|numeric',
            'due_amount'      => 'required|numeric',
            'payment_status'  => 'required|in:Paid,Due,Partial',
            'payment_method'  => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'received_date'   => 'nullable|date',
            'status'          => 'required|in:Pending,Received,Cancelled',
            'note'            => 'nullable|string',
        ]);

        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        $validated['created_by'] = auth()->id() ?? 1;

        Purchase::create($validated);

        return redirect()->route('purchasesIndex')->with('message', '✅ Purchase সফলভাবে তৈরি হয়েছে।');
    }

    // 🟢 Show single purchase
    public function show(Purchase $purchase)
    {
        return view('pages.purchases.historyPurchase', compact('purchase'));
    }

    // 🟢 Edit form
    public function edit(Purchase $purchase)
    {
        $vendors = Vendor::all();
        return view('pages.purchases.editPurchase', compact('purchase', 'vendors'));
    }

    // 🟢 Update
    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'purchase_date'   => 'required|date',
            'invoice_no'      => 'required|string|max:50|unique:purchases,invoice_no,' . $purchase->id,
            'vendor_id'       => 'required|integer|exists:vendors,id',
            'reference_no'    => 'nullable|string|max:100',
            'total_qty'       => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'discount_amount' => 'nullable|numeric',
            'tax_amount'      => 'nullable|numeric',
            'shipping_cost'   => 'nullable|numeric',
            'grand_total'     => 'required|numeric',
            'paid_amount'     => 'required|numeric',
            'due_amount'      => 'required|numeric',
            'payment_status'  => 'required|in:Paid,Due,Partial',
            'payment_method'  => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'received_date'   => 'nullable|date',
            'status'          => 'required|in:Pending,Received,Cancelled',
            'note'            => 'nullable|string',
        ]);

        if ($request->hasFile('invoice_file')) {
            $validated['invoice_file'] = $request->file('invoice_file')->store('invoices', 'public');
        }

        $purchase->update($validated);

        return redirect()->route('purchasesIndex')->with('message', '✅ Purchase আপডেট হয়েছে।');
    }

    // 🟢 Delete
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchasesIndex')->with('message', '🗑️ Purchase মুছে ফেলা হয়েছে।');
    }
}
