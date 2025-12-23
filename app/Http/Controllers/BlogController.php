<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog; 
use App\Models\Comment; 
use App\Models\Like;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(6);
        return view('blogs.index', compact('blogs'));
    }

    public function show(Blog $blog)
    {
        $comments = $blog->comments()->with('user')->latest()->get();
        $liked = auth()->check() ? $blog->likes()->where('user_id', auth()->id())->exists() : false;
        return view('blogs.show', compact('blog', 'comments', 'liked'));
    }

    public function comment(Request $request, Blog $blog)
    {
        $request->validate(['body' => 'required']);
        $blog->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
        return back();
    }

    public function like(Blog $blog)
    {
        $blog->likes()->firstOrCreate(['user_id' => auth()->id()]);
        return back();
    }

    public function unlike(Blog $blog)
    {
        $blog->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}

