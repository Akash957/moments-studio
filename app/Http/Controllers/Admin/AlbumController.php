<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('service')->latest()->paginate(15);
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.albums.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
        ]);

        Album::create([
            'title'        => $request->title,
            'slug'         => Album::generateUniqueSlug($request->title),
            'couple_names' => $request->client_name ?? $request->couple_names,
            'event_date'   => $request->event_date,
            'location'     => $request->location,
            'cover_image'  => $request->cover_image,
            'description'  => $request->description,
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_published') || $request->has('is_active'),
        ]);

        return redirect()->route('admin.albums.index')->with('success', 'Photo album created successfully.');
    }

    public function edit($id)
    {
        $album = Album::findOrFail($id);
        $services = Service::all();
        return view('admin.albums.edit', compact('album', 'services'));
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:150',
        ]);

        $album->update([
            'title'        => $request->title,
            'couple_names' => $request->client_name ?? $request->couple_names,
            'event_date'   => $request->event_date,
            'location'     => $request->location,
            'cover_image'  => $request->cover_image,
            'description'  => $request->description,
            'is_featured'  => $request->has('is_featured'),
            'is_active'    => $request->has('is_published') || $request->has('is_active'),
        ]);

        return redirect()->route('admin.albums.index')->with('success', 'Photo album updated successfully.');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return back()->with('success', 'Album deleted successfully.');
    }
}
