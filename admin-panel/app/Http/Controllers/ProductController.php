<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with(['category', 'subCategory', 'productUnit'])->paginate(10);
        return view('pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $productUnits = ProductUnit::all();

        return view('pages.products.create', compact('categories', 'subCategories', 'productUnits'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category_id' => 'required|integer|exists:sub_categories,id',
            'productunit_id' => 'required|integer|exists:product_units,id',
            'barcode' => 'nullable|string|max:100|unique:products,barcode',
            'description' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'subCategory', 'productUnit']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $productUnits = ProductUnit::all();

        return view('pages.products.edit', compact('product', 'categories', 'subCategories', 'productUnits'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:150',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'sub_category_id' => 'sometimes|required|integer|exists:sub_categories,id',
            'productunit_id' => 'sometimes|required|integer|exists:product_units,id',
            'barcode' => "nullable|string|max:100|unique:products,barcode,{$product->id}",
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
