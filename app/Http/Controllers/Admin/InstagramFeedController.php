<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramFeed;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InstagramFeedController extends Controller
{
    public function index()
    {
        if (InstagramFeed::count() === 0) {
            $initialPosts = [
                ['media_url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?w=400&h=400&fit=crop', 'caption' => 'Capturing timeless wedding moments under golden light', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 1],
                ['media_url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=400&h=400&fit=crop', 'caption' => 'Romantic couple portrait at sunset', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 2],
                ['media_url' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400&h=400&fit=crop', 'caption' => 'Beautiful rings and details of love', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 3],
                ['media_url' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?w=400&h=400&fit=crop', 'caption' => 'Ceremony magical vibes and outdoor setup', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 4],
                ['media_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=400&h=400&fit=crop', 'caption' => 'Royal Indian wedding celebration moments', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 5],
                ['media_url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=400&h=400&fit=crop', 'caption' => 'Pre-wedding destination shoot memories', 'permalink' => 'https://instagram.com/lovestudios', 'sort_order' => 6],
            ];
            foreach ($initialPosts as $p) {
                InstagramFeed::create([
                    'media_url'     => $p['media_url'],
                    'thumbnail_url' => $p['media_url'],
                    'caption'       => $p['caption'],
                    'permalink'     => $p['permalink'],
                    'sort_order'    => $p['sort_order'],
                    'is_active'     => true,
                ]);
            }
        }

        $feeds = InstagramFeed::ordered()->paginate(15);

        $settings = [
            'instagram_section_label'    => Setting::get('instagram_section_label', 'Instagram'),
            'instagram_section_title'    => Setting::get('instagram_section_title', 'Follow Our Journey'),
            'site_instagram'             => Setting::get('site_instagram', '@momentsstudio'),
            'social_instagram'           => Setting::get('social_instagram', 'https://instagram.com/lovestudios'),
        ];

        return view('admin.instagram_feeds.index', compact('feeds', 'settings'));
    }

    public function create()
    {
        return view('admin.instagram_feeds.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'caption'     => 'nullable|string|max:1000',
            'permalink'   => 'nullable|string|max:500',
            'media_url'   => 'nullable|string|max:1000',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order'  => 'nullable|integer',
        ]);

        $mediaUrl = $request->media_url;

        // Handle Image File Upload if provided
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            $destinationPath = public_path('uploads/instagram');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            $mediaUrl = asset('uploads/instagram/' . $filename);
        }

        if (empty($mediaUrl)) {
            return back()->withInput()->with('error', 'Please upload an image file or provide an Image URL.');
        }

        InstagramFeed::create([
            'media_url'      => $mediaUrl,
            'thumbnail_url'  => $mediaUrl,
            'caption'        => $request->caption,
            'permalink'      => $request->permalink ?? Setting::get('social_instagram', 'https://instagram.com'),
            'like_count'     => $request->like_count ?? 0,
            'comments_count' => $request->comments_count ?? 0,
            'sort_order'     => $request->sort_order ?? 0,
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->route('admin.instagram-feeds.index')->with('success', 'Instagram post added successfully.');
    }

    public function edit($id)
    {
        $feed = InstagramFeed::findOrFail($id);
        return view('admin.instagram_feeds.edit', compact('feed'));
    }

    public function update(Request $request, $id)
    {
        $feed = InstagramFeed::findOrFail($id);

        $request->validate([
            'caption'     => 'nullable|string|max:1000',
            'permalink'   => 'nullable|string|max:500',
            'media_url'   => 'nullable|string|max:1000',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'sort_order'  => 'nullable|integer',
        ]);

        $mediaUrl = $request->media_url ?? $feed->media_url;

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            $destinationPath = public_path('uploads/instagram');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            $mediaUrl = asset('uploads/instagram/' . $filename);
        }

        $feed->update([
            'media_url'      => $mediaUrl,
            'thumbnail_url'  => $mediaUrl,
            'caption'        => $request->caption,
            'permalink'      => $request->permalink ?? $feed->permalink,
            'like_count'     => $request->like_count ?? $feed->like_count,
            'comments_count' => $request->comments_count ?? $feed->comments_count,
            'sort_order'     => $request->sort_order ?? 0,
            'is_active'      => $request->has('is_active'),
        ]);

        return redirect()->route('admin.instagram-feeds.index')->with('success', 'Instagram post updated successfully.');
    }

    public function destroy($id)
    {
        $feed = InstagramFeed::findOrFail($id);
        $feed->delete();
        return back()->with('success', 'Instagram post deleted successfully.');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'instagram_section_label' => 'required|string|max:100',
            'instagram_section_title' => 'required|string|max:200',
            'site_instagram'          => 'required|string|max:100',
            'social_instagram'        => 'required|url|max:255',
        ]);

        Setting::set('instagram_section_label', $request->instagram_section_label, 'text', 'homepage');
        Setting::set('instagram_section_title', $request->instagram_section_title, 'text', 'homepage');
        Setting::set('site_instagram', $request->site_instagram, 'text', 'social');
        Setting::set('social_instagram', $request->social_instagram, 'text', 'social');

        return back()->with('success', 'Instagram Section settings updated successfully!');
    }
}
