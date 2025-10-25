<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

// ক্লাসের নাম OneToManyController থেকে PostCommentController-এ পরিবর্তন করা হলো
class PostCommentController extends Controller
{
    /**
     * Display a listing of the Post resources (Index for Posts).
     * এটি resources/views/index.blade.php ভিউতে $posts ডেটা পাঠাবে।
     */
    public function index()
    {
        // সমস্ত পোস্ট এবং তাদের মন্তব্য Eager Load করা হলো
        $posts = Post::with('comments')->get();

        // ভিউ: index.blade.php (Post Index)
        return view('index', compact('posts'));
    }

    /**
     * Display a listing of the Comment resources (Index for Comments).
     * এটি resources/views/comments/index.blade.php ভিউতে $comments ডেটা পাঠাবে।
     */
    public function listComments()
    {
        // সমস্ত মন্তব্য এবং তাদের Parent Post Eager Load করা হলো
        $comments = Comment::with('post')->get();

        // ভিউ: comments/index.blade.php (Comment Index)
        return view('comments.index', compact('comments'));
    }

    /**
     * Display the specified Comment resource. (View Only Detail)
     * এটি resources/views/comments/show.blade.php ভিউতে $comment ডেটা পাঠাবে।
     */
    public function show($id)
    {
        // নির্দিষ্ট মন্তব্য এবং তার পোস্ট ডেটা লোড করা হলো, না পেলে 404
        $comment = Comment::with('post')->findOrFail($id);

        // ভিউ: comments/show.blade.php (Comment Detail)
        return view('comments.show', compact('comment'));
    }
}
