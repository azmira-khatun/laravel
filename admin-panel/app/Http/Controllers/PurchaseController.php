<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::all();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_date'   => 'required|date',
            'invoice_no'      => 'required|string|max:50|unique:purchases',
            'vendor_id'       => 'required|integer|exists:vendors,id',
            'total_qty'       => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'grand_total'     => 'required|numeric',
            'paid_amount'     => 'required|numeric',
            'due_amount'      => 'required|numeric',
            'payment_status'  => 'required|in:Paid,Due,Partial',
            'payment_method'  => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'status'          => 'required|in:Pending,Received,Cancelled',
            // অন্যান্য ভ্যালিডেশন যুক্ত করুন
        ]);

        // আপনি চাইলে ফাইল আপলোডের লজিকও যোগ করতে পারেন
        if ($request->hasFile('invoice_file')) {
            $path = $request->file('invoice_file')->store('invoices', 'public');
            $validated['invoice_file'] = $path;
        }

        $validated['created_by'] = auth()->id();  // যদি লগইন ইউজার থাকে

        Purchase::create($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase তৈরি হয়েছে।');
    }

    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        return view('purchases.edit', compact('purchase'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validated = $request->validate([
            'purchase_date'   => 'required|date',
            'invoice_no'      => 'required|string|max:50|unique:purchases,invoice_no,'.$purchase->id,
            'vendor_id'       => 'required|integer|exists:vendors,id',
            'total_qty'       => 'required|integer',
            'subtotal_amount' => 'required|numeric',
            'grand_total'     => 'required|numeric',
            'paid_amount'     => 'required|numeric',
            'due_amount'      => 'required|numeric',
            'payment_status'  => 'required|in:Paid,Due,Partial',
            'payment_method'  => 'required|in:Cash,Bank,Mobile,Cheque,Other',
            'status'          => 'required|in:Pending,Received,Cancelled',
            // অন্যান্য ভ্যালিডেশন …
        ]);

        if ($request->hasFile('invoice_file')) {
            $path = $request->file('invoice_file')->store('invoices', 'public');
            $validated['invoice_file'] = $path;
        }

        $purchase->update($validated);

        return redirect()->route('purchases.index')->with('success', 'Purchase আপডেট হয়েছে।');
    }

    public function destroy(Purchase $purchase)
    {
        // যদি ইনভয়েস ফাইল থাকলে চাইলে ডিলেট করতে পারেন
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase মুছে দেওয়া হয়েছে।');
    }
}
