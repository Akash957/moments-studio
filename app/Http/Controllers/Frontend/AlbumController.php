<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $categories = GalleryCategory::withCount('albums')->get();
        $albums = Album::with(['category', 'images'])
            ->latest()
            ->paginate(9);

        return view('frontend.gallery.albums', compact('albums', 'categories'));
    }

    public function show(string $slug)
    {
        $album   = Album::where('slug', $slug)->orWhere('id', $slug)->with(['images', 'category'])->firstOrFail();
        $related = Album::where('id', '!=', $album->id)->limit(3)->get();

        return view('frontend.gallery.album-detail', compact('album', 'related'));
    }
}
