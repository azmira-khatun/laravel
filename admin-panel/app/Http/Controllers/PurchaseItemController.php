<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    // Display a paginated list of purchase items
    public function index()
    {
        // Eager load purchase, product, and product unit
        $items = PurchaseItem::with(['purchase', 'product', 'productunit'])
                             ->orderBy('id', 'desc')
                             ->paginate(10);

        return view('pages.purchase_items.index', compact('items'));
    }

    // Show form to create a new purchase item
    public function create()
    {
        return view('pages.purchase_items.create');
    }

    // Store a new purchase item in the database
    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_id'   => 'required|integer|exists:purchases,id',
            'product_id'    => 'required|integer|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|numeric',
            'line_discount' => 'nullable|numeric',
            'line_total'    => 'required|numeric',
        ]);

        PurchaseItem::create($data);

        return redirect()->route('purchase_items.index')
                         ->with('success', 'Purchase item added successfully.');
    }

    // Show details of a single purchase item
    public function show(PurchaseItem $purchaseItem)
    {
        return view('pages.purchase_items.show', compact('purchaseItem'));
    }

    // Show form to edit an existing purchase item
    public function edit(PurchaseItem $purchaseItem)
    {
        return view('pages.purchase_items.edit', compact('purchaseItem'));
    }

    // Update an existing purchase item
    public function update(Request $request, PurchaseItem $purchaseItem)
    {
        $data = $request->validate([
            'purchase_id'   => 'required|integer|exists:purchases,id',
            'product_id'    => 'required|integer|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|numeric',
            'line_discount' => 'nullable|numeric',
            'line_total'    => 'required|numeric',
        ]);

        $purchaseItem->update($data);

        return redirect()->route('purchase_items.index')
                         ->with('success', 'Purchase item updated successfully.');
    }

    // Delete a purchase item
    public function destroy(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();

        return redirect()->route('purchase_items.index')
                         ->with('success', 'Purchase item deleted successfully.');
    }
}
