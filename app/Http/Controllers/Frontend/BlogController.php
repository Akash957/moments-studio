<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author', 'tags']);

        if ($request->category) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->tag) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $blogs      = $query->latest()->paginate(9);
        $categories = BlogCategory::withCount('blogs')->get();
        $tags       = BlogTag::withCount('blogs')->get();
        $featured   = Blog::latest()->limit(3)->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags', 'featured'));
    }

    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->orWhere('id', $slug)
            ->with(['category', 'author', 'tags', 'comments'])
            ->firstOrFail();

        $blog->incrementViews();

        $related = Blog::where('id', '!=', $blog->id)
            ->limit(3)
            ->get();

        $prev = Blog::where('id', '<', $blog->id)->latest('id')->first();
        $next = Blog::where('id', '>', $blog->id)->oldest('id')->first();

        return view('frontend.blog.show', compact('blog', 'related', 'prev', 'next'));
    }
}
