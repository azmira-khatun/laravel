<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        $invoices = PurchaseInvoice::with('purchase')->latest()->paginate(10);
        return view('purchase_invoices.index', compact('invoices'));
    }

    public function create()
    {
        $purchases = Purchase::all();
        return view('purchase_invoices.create', compact('purchases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:100|unique:purchase_invoices',
            'purchase_id' => 'required|exists:purchases,id|unique:purchase_invoices',
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'due_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:50',
        ]);

        PurchaseInvoice::create($request->all());

        return redirect()->route('purchaseInvoices.index')->with('success', 'Purchase invoice created successfully.');
    }

    public function show(PurchaseInvoice $purchaseInvoice)
    {
        return view('purchase_invoices.show', compact('purchaseInvoice'));
    }

    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        $purchases = Purchase::all();
        return view('purchase_invoices.edit', compact('purchaseInvoice', 'purchases'));
    }

    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $request->validate([
            'invoice_number' => 'required|string|max:100|unique:purchase_invoices,invoice_number,' . $purchaseInvoice->id,
            'purchase_id' => 'required|exists:purchases,id|unique:purchase_invoices,purchase_id,' . $purchaseInvoice->id,
            'invoice_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'due_amount' => 'nullable|numeric',
            'payment_status' => 'nullable|string|max:50',
        ]);

        $purchaseInvoice->update($request->all());

        return redirect()->route('purchaseInvoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        $purchaseInvoice->delete();
        return redirect()->route('purchaseInvoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
