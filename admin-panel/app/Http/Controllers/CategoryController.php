<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::all();
        // return $cats;
        return view('pages.category.view_category', compact('cats'));
    }


    public function create()
    {
        return view('pages.category.add_category');
    }

    public function store(Request $request)
    {

        Category::create($request->only([
            'name',
            'price',
        ]));
        // dd($request->all());


        return Redirect::to('/category');
    }


    public function destroy(Request $request)
    {
        $product = Category::find($request->catagory_id);
        $product->delete();
        return Redirect::to('/category');
    }
    public function update($catagory_id)
    {
        $cat = Category::find($catagory_id);
        return view('pages.category.edit_category', compact('cat'));
    }

    public function editStore(Request $request)
    {
        $cat = Category::find($request->catagory_id);
        $cat->name = $request->name;
        $cat->price = $request->price;
        $cat->save();
        return Redirect::to('/category');
    }
}
