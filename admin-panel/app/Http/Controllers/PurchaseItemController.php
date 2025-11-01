<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    // Display all purchase items
    public function index()
    {
        $purchaseItems = PurchaseItem::all();
        return view('pages.purchase_items.index', compact('purchaseItems'));
    }

    // Show the form to create a new purchase item
    public function create()
    {
        $purchases = \App\Models\Purchase::all();
        $products = \App\Models\Product::all();
        $units = \App\Models\ProductUnit::all();

        return view('pages.purchase_items.create', compact('purchases', 'products', 'units'));
    }

    // Store a new purchase item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id' => 'required|integer|exists:purchases,id',
            'product_id' => 'required|integer|exists:products,id',
            'unit_id' => 'required|integer|exists:product_units,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
            'purchased_date' => 'required|date',
        ]);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        PurchaseItem::create($validated);

        return redirect()->route('purchaseItems.index')->with('success', 'Purchase Item added successfully.');
    }

    // Show a single purchase item
    public function show($id)
    {
        $item = PurchaseItem::with(['purchase', 'product', 'unit'])->findOrFail($id);
        return view('pages.purchase_items.show', compact('item'));
    }

    // Show the form to edit an existing purchase item
    public function edit($id)
    {
        $item = PurchaseItem::findOrFail($id);
        $purchases = \App\Models\Purchase::all();
        $products = \App\Models\Product::all();
        $units = \App\Models\ProductUnit::all();

        return view('pages.purchase_items.edit', compact('item', 'purchases', 'products', 'units'));
    }

    // Update an existing purchase item
    public function update(Request $request, $id)
    {
        $item = PurchaseItem::findOrFail($id);

        $validated = $request->validate([
            'purchase_id' => 'required|integer|exists:purchases,id',
            'product_id' => 'required|integer|exists:products,id',
            'unit_id' => 'required|integer|exists:product_units,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'required|numeric|min:0',
            'purchased_date' => 'required|date',
        ]);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $item->update($validated);

        return redirect()->route('purchaseItems.index')->with('success', 'Purchase Item updated successfully.');
    }

    // Delete a purchase item
    public function destroy($id)
    {
        $item = PurchaseItem::findOrFail($id);
        $item->delete();

        return redirect()->route('purchaseItems.index')->with('success', 'Purchase Item deleted successfully.');
    }
}
