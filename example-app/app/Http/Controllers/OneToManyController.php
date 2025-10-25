<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

class OneToManyController extends Controller
{
    public function index()
    {
        $posts = Post::with('comments')->get();
        // return $posts;
        return view('index', compact('posts'));

    }
}
