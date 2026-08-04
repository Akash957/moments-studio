<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::active()->paginate(12);
        return view('frontend.videos.index', compact('videos'));
    }

    public function show(string $slug)
    {
        $video = Video::where('slug', $slug)->where('is_active', true)->first();
        if (!$video) {
            $video = Video::where('id', $slug)->where('is_active', true)->first();
        }

        $relatedVideos = Video::active()->where('id', '!=', $video?->id)->limit(3)->get();

        return view('frontend.videos.show', compact('video', 'relatedVideos'));
    }
}
