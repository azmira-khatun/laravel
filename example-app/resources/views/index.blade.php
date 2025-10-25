<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the Post resources (Index for Posts).
     */
    public function index()
    {
        $posts = Post::with('comments')->get();
        // এটি resources/views/index.blade.php কে কল করবে
        return view('index', compact('posts'));
    }

    /**
     * Display a listing of the Comment resources (Index for Comments).
     * এটি resources/views/comments/index.blade.php ভিউতে $comments ডেটা পাঠাবে।
     */
    public function listComments()
    {
        // Inverse One-to-Many: Post রিলেশনশিপ Eager Load করা হলো
        $comments = Comment::with('post')->get();

        // ভিউতে $comments ভেরিয়েবলটি পাঠানো হলো
        return view('comments.index', compact('comments'));
    }

    /**
     * Display the specified Comment resource. (View Only Detail)
     */
    public function show($id)
    {
        // নির্দিষ্ট মন্তব্য এবং তার পোস্ট ডেটা লোড করা হলো
        $comment = Comment::with('post')->findOrFail($id);
        // এটি resources/views/comments/show.blade.php ভিউতে $comment পাঠাবে
        return view('comments.show', compact('comment'));
    }

    // যেহেতু আপনি শুধুমাত্র দেখতে চেয়েছেন (View Only), তাই সমস্ত CRUD মেথড (create, store, edit, update, destroy) সরিয়ে দেওয়া হলো।
}
