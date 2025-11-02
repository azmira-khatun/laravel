<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->latest()->paginate(15);
        return view('pages.stocks.index', compact('stocks'));
    }

    public function create()
    {
        $products = Product::all();
        return view('pages.stocks.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'       => 'required|exists:products,id',
            'transaction_type' => 'required|string|in:purchase,purchase_return,sale,sale_return',
            'quantity'         => 'required|integer|min:1',
            'note'             => 'nullable|string',
        ]);

        DB::transaction(function() use ($validated, $request) {
            $product = Product::findOrFail($validated['product_id']);

            if ($validated['transaction_type'] === 'purchase') {
                $product->stock_quantity = ($product->stock_quantity ?? 0) + $validated['quantity'];
            }
            elseif ($validated['transaction_type'] === 'purchase_return') {
                $product->stock_quantity = max(0, ($product->stock_quantity ?? 0) - $validated['quantity']);
            }
            elseif ($validated['transaction_type'] === 'sale') {
                $product->stock_quantity = max(0, ($product->stock_quantity ?? 0) - $validated['quantity']);
            }
            elseif ($validated['transaction_type'] === 'sale_return') {
                $product->stock_quantity = ($product->stock_quantity ?? 0) + $validated['quantity'];
            }

            $product->save();

            Stock::create([
                'product_id'        => $product->id,
                'product_name'      => $product->name,
                'transaction_type'  => $validated['transaction_type'],
                'quantity'          => $validated['quantity'],
                'stock_after'       => $product->stock_quantity,
                'note'              => $validated['note'] ?? null,
                'movement_date'     => now(),
            ]);
        });

        return redirect()->route('stocks.index')->with('success', 'Stock movement recorded successfully!');
    }

    public function show(Stock $stock)
    {
        return view('pages.stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $products = Product::all();
        return view('pages.stocks.edit', compact('stock','products'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'transaction_type' => 'required|string|in:purchase,purchase_return,sale,sale_return',
            'quantity'         => 'required|integer|min:1',
            'note'              => 'nullable|string',
        ]);

        $stock->update($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock movement updated successfully!');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock movement deleted successfully!');
    }
}
