<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $categories = GalleryCategory::withCount('galleries')->get();
        $category   = $request->get('category');

        $query = Gallery::with('category')->latest();
        if ($category && $category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        $galleries = $query->paginate(18);

        return view('frontend.gallery.index', compact('galleries', 'categories', 'category'));
    }

    public function ajaxLoad(Request $request)
    {
        $query    = Gallery::with('category')->latest();
        $category = $request->get('category');
        if ($category && $category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }

        $galleries = $query->paginate(12, ['*'], 'page', $request->get('page', 1));
        return response()->json([
            'items'   => $galleries->items(),
            'hasMore' => $galleries->hasMorePages(),
        ]);
    }
}
