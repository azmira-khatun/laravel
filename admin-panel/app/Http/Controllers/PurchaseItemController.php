<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index()
    {
        $items = PurchaseItem::with(['purchase','product'])->orderBy('id','desc')->paginate(10);
        return view('pages.purchase_items.index', compact('items'));
    }

    public function create()
    {
        return view('pages.purchase_items.create');
    }

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

        return redirect()->route('purchase_items.index')->with('success','Purchase item added.');
    }

    public function show(PurchaseItem $purchaseItem)
    {
        return view('purchase_items.show', compact('purchaseItem'));
    }

    public function edit(PurchaseItem $purchaseItem)
    {
        return view('pages.purchase_items.edit', compact('purchaseItem'));
    }

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

        return redirect()->route('purchase_items.index')->with('success','Purchase item updated.');
    }

    public function destroy(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();
        return redirect()->route('purchase_items.index')->with('success','Purchase item deleted.');
    }
}
