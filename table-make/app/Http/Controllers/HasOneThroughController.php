<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HasOneThroughController extends Controller
{
    public function index()
    {
        $categories = Category::with('order')->get();


        return view('hasone.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with('order')->findOrFail($id);

        $order = $category->order; 
        return response()->json([
            'category' => $category,
            'order' => $order
        ]);
    }
}
