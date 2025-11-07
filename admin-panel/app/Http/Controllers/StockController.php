<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['product', 'user'])->get();
        return response()->json($stocks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id|unique:stocks,product_id',
            'quantity'   => 'required|integer|min:0',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $stock = Stock::create($validated);

        return response()->json($stock, 201);
    }

    public function show(Stock $stock)
    {
        return response()->json($stock->load(['product', 'user']));
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'product_id' => 'sometimes|required|exists:products,id|unique:stocks,product_id,'.$stock->id,
            'quantity'   => 'sometimes|required|integer|min:0',
            'user_id'    => 'nullable|exists:users,id',
        ]);

        $stock->update($validated);

        return response()->json($stock);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(null, 204);
    }
}
