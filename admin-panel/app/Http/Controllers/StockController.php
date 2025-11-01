<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['product','vendor','customer'])->latest()->paginate(15);
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $products  = Product::all();
        $vendors   = Vendor::all();
        $customers = Customer::all();
        return view('stocks.create', compact('products','vendors','customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'        => 'required|exists:products,id',
            'product_name'      => 'required|string|max:100',
            'category_id'       => 'nullable|exists:categories,id',
            'vendor_id'         => 'nullable|exists:vendors,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'transaction_type'  => 'required|string',
            'quantity'          => 'required|integer|min:1',
            // অন্যান্য ফিল্ড ভ্যালিডেশন করতে পারেন
        ]);

        DB::transaction(function() use ($data) {
            $product = Product::find($data['product_id']);
            // স্টক ম্যানেজমেন্ট লজিক
            if ($data['transaction_type'] === 'sale') {
                if ($product->stock_quantity < $data['quantity']) {
                    throw new \Exception('Not enough stock');
                }
                $product->stock_quantity -= $data['quantity'];
            } else {
                // purchase, return ইত্যাদি ক্ষেত্রে স্টক বাড়ানো বা কমানো
                $product->stock_quantity += $data['quantity'];
            }
            $product->save();

            $data['stock_after'] = $product->stock_quantity;

            Stock::create($data);
        });

        return redirect()->route('stocks.index')->with('success', 'Stock movement recorded successfully!');
    }

    public function show(Stock $stock)
    {
        return view('stocks.show', compact('stock'));
    }

    public function edit(Stock $stock)
    {
        $products  = Product::all();
        $vendors   = Vendor::all();
        $customers = Customer::all();
        return view('stocks.edit', compact('stock','products','vendors','customers'));
    }

    public function update(Request $request, Stock $stock)
    {
        $data = $request->validate([
            'product_id'        => 'required|exists:products,id',
            'product_name'      => 'required|string|max:100',
            'transaction_type'  => 'required|string',
            'quantity'          => 'required|integer|min:1',
            // অন্যান্য ফিল্ড…
        ]);

        // সাধারণভাবে স্টক আপডেট করতে হলে আগের রেকর্ডের লজিক পরিবর্তন প্রয়োজন
        $stock->update($data);

        return redirect()->route('stocks.index')->with('success', 'Stock record updated!');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Stock record deleted!');
    }
}
