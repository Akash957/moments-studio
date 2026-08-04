<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'author'])->latest()->paginate(15);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required',
        ]);

        Blog::create([
            'title'          => $request->title,
            'slug'           => Str::slug($request->title),
            'excerpt'        => $request->excerpt,
            'content'        => $request->content,
            'category_id'    => $request->category_id,
            'author_id'      => auth()->id(),
            'status'         => $request->status ?? 'published',
            'published_at'   => now(),
            'featured_image' => $request->featured_image,
            'reading_time'   => $request->reading_time ?? 5,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully.');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $request->validate([
            'title'   => 'required|string|max:200',
            'content' => 'required',
        ]);

        $blog->update([
            'title'          => $request->title,
            'excerpt'        => $request->excerpt,
            'content'        => $request->content,
            'category_id'    => $request->category_id,
            'status'         => $request->status,
            'featured_image' => $request->featured_image,
            'reading_time'   => $request->reading_time,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return back()->with('success', 'Blog post deleted successfully.');
    }
}
