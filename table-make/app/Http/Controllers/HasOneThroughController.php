<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HasOneThroughController extends Controller
{
    public function index()
    {
        $categories = Category::with('products.order')->get();
        return view('hasone.index', compact('categories'));
    }
}
