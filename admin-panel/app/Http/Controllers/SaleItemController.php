<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleItemController extends Controller
{
    /**
     * Show all items of a given sale.
     */
    public function index($saleId)
    {
        $sale = Sale::with('items.product')->findOrFail($saleId);
        return view('pages.sales.items.index', compact('sale'));
    }

    /**
     * Show the form for adding a new item to a sale (or handling return).
     */
    public function create($saleId)
    {
        $sale     = Sale::findOrFail($saleId);
        $products = Product::all();
        return view('pages.sales.items.create', compact('sale', 'products'));
    }

    /**
     * Store a new sale item (or return item) and update product stock accordingly.
     */
    public function store(Request $request, $saleId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'type'       => 'required|string|in:sale_item,return_item',
        ]);

        DB::transaction(function() use ($request, $saleId) {
            $sale    = Sale::findOrFail($saleId);
            $product = Product::findOrFail($request->product_id);

            if ($request->type === 'sale_item') {
                // এক নতুন বিক্রয়ের লাইন – স্টক কমানো
                $product->adjustStock($request->quantity, 'decrease');
            } elseif ($request->type === 'return_item') {
                // রিটার্ন পণ্য – স্টক বাড়ানো
                $product->adjustStock($request->quantity, 'increase');
            }

            SaleItem::create([
                'sale_id'     => $sale->id,
                'product_id'  => $product->id,
                'quantity'    => $request->quantity,
                'unit_price'  => $request->unit_price,
                'total_price' => $request->quantity * $request->unit_price,
            ]);
        });

        return redirect()->route('sales.items.index', $saleId)
                         ->with('success', 'Item processed and stock updated!');
    }

    /**
     * Delete a sale item (or return) and adjust stock back.
     */
    public function destroy($saleId, $itemId)
    {
        DB::transaction(function() use ($saleId, $itemId) {
            $item    = SaleItem::findOrFail($itemId);
            $product = Product::findOrFail($item->product_id);

            // এখানে ধারণা করা হচ্ছে—itemটি পূর্বে sale_item বা return_item ছিল
            // স্টক পুনরুদ্ধার:
            $product->adjustStock($item->quantity, 'increase');

            $item->delete();
        });

        return redirect()->route('sales.items.index', $saleId)
                         ->with('success', 'Item removed and stock restored!');
    }
}
