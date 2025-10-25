<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ManyToManyController extends Controller
{
    public function index()
    {
        $products = Brand::with('products')->get();
        return $products;
        // return view('pages.many_to_many', compact('products'));

        // $comments = Comment::with('post')->get();
        //   //    return  $post;
        //    return view('post',compact('comments'));   


    }
}