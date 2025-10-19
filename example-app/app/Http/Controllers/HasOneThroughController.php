<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Mechanie;
use App\Models\Owner;


class HasOneThroughController extends Controller
{
    public function index()
    {
        $posts = Mechanie::with('carOwner')->get();
        // return $posts;
        return view('relation_table.index', compact('posts'));
    }
}
