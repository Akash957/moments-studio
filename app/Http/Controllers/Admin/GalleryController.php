<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::with('category')->latest()->paginate(24);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        $categories = GalleryCategory::all();
        return view('admin.gallery.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'image' => 'required|string',
        ]);
        
        Gallery::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'image'       => $request->image,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo added to gallery portfolio successfully.');
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $categories = GalleryCategory::all();
        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'image'       => $request->image,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery photo updated successfully.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();
        return back()->with('success', 'Photo removed from gallery.');
    }
}
