<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            $destinationPath = public_path('uploads/media');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            $url = asset('uploads/media/' . $filename);

            Media::create([
                'uploaded_by'   => auth()->id(),
                'name'          => $file->getClientOriginalName(),
                'original_name' => $file->getClientOriginalName(),
                'path'          => 'uploads/media/' . $filename,
                'url'           => $url,
                'disk'          => 'public',
                'mime_type'     => $file->getClientMimeType() ?? 'image/png',
                'extension'     => $extension,
                'size'          => filesize($destinationPath . '/' . $filename),
            ]);

            return back()->with('success', 'Media file uploaded successfully!');
        }

        if ($request->filled('url')) {
            $request->validate(['url' => 'required|url']);
            $url = $request->url;
            $filename = basename(parse_url($url, PHP_URL_PATH) ?? 'external-image.jpg');

            Media::create([
                'uploaded_by'   => auth()->id(),
                'name'          => $filename,
                'original_name' => $filename,
                'path'          => $url,
                'url'           => $url,
                'disk'          => 'external',
                'mime_type'     => 'image/jpeg',
                'extension'     => 'jpg',
                'size'          => 102400,
            ]);

            return back()->with('success', 'Media asset link added successfully!');
        }

        return back()->with('error', 'Please upload a file or enter a valid image URL.');
    }

    public function destroy($id)
    {
        $item = Media::findOrFail($id);
        
        // Remove local file if exists
        if ($item->disk === 'public' && file_exists(public_path($item->path))) {
            @unlink(public_path($item->path));
        }

        $item->delete();
        return back()->with('success', 'Media file removed successfully.');
    }
}
