<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('album')->latest()->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $albums = Album::all();
        return view('admin.videos.create', compact('albums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:200',
            'video_url' => 'required|url',
        ]);

        $videoType = in_array($request->video_type, ['youtube', 'vimeo', 'local']) ? $request->video_type : 'local';

        Video::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'album_id'    => $request->album_id,
            'video_url'   => $request->video_url,
            'video_type'  => $videoType,
            'thumbnail'   => $request->thumbnail,
            'duration'    => $request->duration,
            'location'    => $request->location,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Cinematic video film added successfully.');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $albums = Album::all();
        return view('admin.videos.edit', compact('video', 'albums'));
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $request->validate([
            'title'     => 'required|string|max:200',
            'video_url' => 'required|url',
        ]);

        $videoType = in_array($request->video_type, ['youtube', 'vimeo', 'local']) ? $request->video_type : 'local';

        $video->update([
            'title'       => $request->title,
            'album_id'    => $request->album_id,
            'video_url'   => $request->video_url,
            'video_type'  => $videoType,
            'thumbnail'   => $request->thumbnail,
            'duration'    => $request->duration,
            'location'    => $request->location,
            'description' => $request->description,
            'is_featured' => $request->has('is_featured'),
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();
        return back()->with('success', 'Video deleted successfully.');
    }
}
