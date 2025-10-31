<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index()
    {
        $items = PurchaseItem::with(['purchase','product','unit'])->get();
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_id'   => 'required|integer|exists:purchases,id',
            'product_id'    => 'required|integer|exists:products,id',
            'unit_id'       => 'required|integer|exists:product_units,id',
            'quantity'      => 'required|numeric|min:0.01',
            'unit_price'    => 'required|numeric|min:0',
            'purchased_date'=> 'required|date',
        ]);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $item = PurchaseItem::create($validated);

        return response()->json($item, 201);
    }

    public function show($id)
    {
        $item = PurchaseItem::with(['purchase','product','unit'])->findOrFail($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = PurchaseItem::findOrFail($id);

        $validated = $request->validate([
            'purchase_id'   => 'sometimes|integer|exists:purchases,id',
            'product_id'    => 'sometimes|integer|exists:products,id',
            'unit_id'       => 'sometimes|integer|exists:product_units,id',
            'quantity'      => 'sometimes|numeric|min:0.01',
            'unit_price'    => 'sometimes|numeric|min:0',
            'purchased_date'=> 'sometimes|date',
        ]);

        if (isset($validated['quantity']) && isset($validated['unit_price'])) {
            $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        }

        $item->update($validated);

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = PurchaseItem::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}
