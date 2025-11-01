<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with('category', 'productUnit')->get();
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $units      = ProductUnit::all();
        return view('pages.products.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:150',
            'category_id'     => 'required|exists:categories,id',
            'productunit_id'  => 'required|exists:product_units,id',
            'barcode'         => 'required|string|unique:products,barcode',
            'description'     => 'nullable|string',
            'stock_quantity'  => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        // যদি stock_quantity না আসে, ডিফল্ট 0 হিসেবে সেট করা যেতে পারে
        if (!isset($data['stock_quantity'])) {
            $data['stock_quantity'] = 0;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $units      = ProductUnit::all();
        return view('pages.products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'            => 'required|string|max:150',
            'category_id'     => 'required|exists:categories,id',
            'productunit_id'  => 'required|exists:product_units,id',
            'barcode'         => 'required|string|unique:products,barcode,' . $product->id,
            'description'     => 'nullable|string',
            'stock_quantity'  => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        // যদি needed হয়, এখানে mix পুরনো stock_quantity রাখা যাবে

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Get specific product info (for ajax / api).
     */
    public function getProductInfo($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'price' => $product->price ?? 0,
            'tax'   => $product->tax_amount ?? 0,
            'shipping' => $product->shipping_cost ?? 0,
            'stock_quantity' => $product->stock_quantity ?? 0,
        ]);
    }
}
