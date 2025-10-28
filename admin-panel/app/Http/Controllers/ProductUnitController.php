<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = ProductUnit::all();
        return view('pages.product_units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        ProductUnit::create([
            'unit_name' => $request->unit_name,
            'description' => $request->description,
        ]);

        return redirect()->route('productUnitStore')->with('message', 'Unit added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = ProductUnit::findOrFail($id);
        return view('pages.product_units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $unit = ProductUnit::findOrFail($id);
        $unit->update($request->only(['unit_name', 'description']));

        return redirect()->route('pages.product_units.index')->with('message', 'Unit updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = ProductUnit::findOrFail($id);
        $unit->delete();

        return redirect()->route('pages.product_units.index')->with('message', 'Unit deleted successfully!');
    }
}
