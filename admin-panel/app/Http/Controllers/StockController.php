<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the stock movements.
     */
    public function index()
    {
        $stocks = Stock::with(['product','vendor','customer'])->latest()->paginate(15);
        return view('pages.stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new stock movement (or purchase entry).
     */
    public function create()
    {
        $products = Product::all();
        // আপনি চাইলে vendors ও customers লোড করতে পারেন:
        // $vendors = Vendor::all();
        // $customers = Customer::all();
        return view('pages.stocks.create', compact('products'));
    }

    /**
     * Store a newly created stock movement and update stock quantity.
     */
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'vendor_id'        => 'required|exists:vendors,id',
            'product_id'       => 'required|exists:products,id',
            'product_name'     => 'required|string|max:100',
            'transaction_type' => 'required|string|in:purchase,sale,purchase_return,sale_return',
            'quantity'         => 'required|integer|min:1',
            'purchase_price'   => 'required|numeric|min:0',
            'unit_price'       => 'nullable|numeric|min:0',
            'return_type'      => 'nullable|string|in:vendor,customer',
            'movement_date'    => 'nullable|date',
            'note'             => 'nullable|string',
        ]);

        DB::transaction(function() use ($validated, $request) {
            // ১) প্রোডাক্ট লোড
            $product = Product::findOrFail($validated['product_id']);

            // ২) স্টক আপডেট লজিক
            if ($validated['transaction_type'] === 'sale') {
                if ($product->stock_quantity < $validated['quantity']) {
                    throw new \Exception('Not enough stock to perform sale.');
                }
                $product->stock_quantity -= $validated['quantity'];
            }
            elseif ($validated['transaction_type'] === 'sale_return') {
                $product->stock_quantity += $validated['quantity'];
            }
            elseif ($validated['transaction_type'] === 'purchase_return') {
                if ($product->stock_quantity < $validated['quantity']) {
                    throw new \Exception('Cannot return more than current stock.');
                }
                $product->stock_quantity -= $validated['quantity'];
            }
            else { // purchase
                $product->stock_quantity += $validated['quantity'];
            }

            $product->save();

            // ৩) মুভমেন্ট রেকর্ড তৈরি
            Stock::create([
                'product_id'       => $product->id,
                'product_name'     => $validated['product_name'],
                'category_id'      => $product->category_id,
                'vendor_id'        => $request->vendor_id,
                'customer_id'      => $request->customer_id ?? null,
                'purchase_id'      => $request->purchase_id ?? null,
                'sale_id'          => $request->sale_id ?? null,
                'transaction_type' => $validated['transaction_type'],
                'quantity'         => $validated['quantity'],
                'stock_after'      => $product->stock_quantity,
                'purchase_price'   => $validated['purchase_price'],
                'sale_price'       => $validated['unit_price'] ?? null,
                'expiry_date'      => $request->expiry_date ?? null,
                'supplier_name'    => $request->supplier_name ?? null,
                'user_id'          => auth()->id(),
                'return_type'      => $validated['return_type'] ?? null,
                'unit_cost'        => $validated['purchase_price'],
                'unit_price'       => $validated['unit_price'] ?? null,
                'movement_date'    => $validated['movement_date'] ?? now(),
                'note'             => $validated['note'] ?? null,
            ]);
        });

        return redirect()->route('stocks.index')->with('success', 'Stock movement recorded and stock quantity updated!');
    }

    /**
     * Display the specified stock movement.
     */
    public function show(Stock $stock)
    {
        $stock->load(['product','vendor','customer']);
        return view('stocks.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified stock movement.
     */
    public function edit(Stock $stock)
    {
        $products = Product::all();
        return view('stocks.edit', compact('stock','products'));
    }

    /**
     * Update the specified stock movement in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'product_id'        => 'required|exists:products,id',
            'product_name'      => 'required|string|max:100',
            'transaction_type'  => 'required|string|in:purchase,sale,purchase_return,sale_return',
            'quantity'          => 'required|integer|min:1',
            'unit_cost'         => 'nullable|numeric|min:0',
            'unit_price'        => 'nullable|numeric|min:0',
            'return_type'       => 'nullable|string|in:vendor,customer',
            'movement_date'     => 'nullable|date',
            'note'              => 'nullable|string',
        ]);

        // এখানে স্টক পরিবর্তনের লজিক বা রিভার্সাল লাগতে পারে – প্রয়োজনে লাগিয়ে নিন
        $stock->update($validated);

        return redirect()->route('stocks.index')->with('success', 'Stock movement updated!');
    }

    /**
     * Remove the specified stock movement from storage.
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock movement deleted!');
    }
}
