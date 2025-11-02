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
     * Show items of a given sale
     */
    public function index($saleId)
    {
        $sale = Sale::with('items.product')->findOrFail($saleId);
        return view('pages.sales.items.index', compact('sale'));
    }

    /**
     * Show form to add a new item to a sale
     */
    public function create($saleId)
    {
        $sale = Sale::findOrFail($saleId);
        $products = Product::all();
        return view('pages.sales.items.create', compact('sale','products'));
    }

    /**
     * Store a new sale item and update product stock
     */
    public function store(Request $request, $saleId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($request, $saleId) {
            $sale = Sale::findOrFail($saleId);
            $product = Product::findOrFail($request->product_id);

            // স্টক চেক ও হ্রাস
            if ($product->stock_quantity < $request->quantity) {
                throw new \Exception("Not enough stock for product {$product->name}");
            }
            $product->decrement('stock_quantity', $request->quantity);

            // SaleItem তৈরি
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'unit_price' => $request->unit_price,
                'total_price'=> $request->quantity * $request->unit_price,
            ]);
        });

        return redirect()->route('sales.items.index', $saleId)
                         ->with('success','Item added and stock updated!');
    }

    /**
     * Remove an item from sale and restore product stock
     */
    public function destroy($saleId, $itemId)
    {
        DB::transaction(function() use ($saleId, $itemId) {
            $item = SaleItem::findOrFail($itemId);
            $product = Product::findOrFail($item->product_id);

            // স্টক পুনরুদ্ধার (রিমুভ হলে)
            $product->increment('stock_quantity', $item->quantity);

            $item->delete();
        });

        return redirect()->route('sales.items.index', $saleId)
                         ->with('success','Item removed and stock restored!');
    }
}
