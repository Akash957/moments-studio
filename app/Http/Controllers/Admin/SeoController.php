<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index(Request $request)
    {
        // Replace legacy Moments Studio titles in database with Love Studios
        SeoMeta::where('title', 'like', '%Moments Studio%')->get()->each(function ($meta) {
            $meta->update([
                'title' => str_replace('Moments Studio', 'Love Studios', $meta->title),
                'og_title' => str_replace('Moments Studio', 'Love Studios', $meta->og_title ?? ''),
                'description' => str_replace('Moments Studio', 'Love Studios', $meta->description ?? ''),
                'og_description' => str_replace('Moments Studio', 'Love Studios', $meta->og_description ?? ''),
            ]);
        });

        $pages = [
            'home'       => 'Homepage (Main)',
            'about'      => 'About Us',
            'services'   => 'Services Listing',
            'gallery'    => 'Gallery Portfolio',
            'albums'     => 'Albums Showcase',
            'blog'       => 'Blog & Stories',
            'contact'    => 'Contact Us',
            'booking'    => 'Book Photography Session',
        ];

        $selectedPage = $request->get('page', 'home');
        $seo = SeoMeta::firstOrCreate(
            ['page' => $selectedPage],
            [
                'title'          => 'Love Studios — Premium Wedding & Event Photography',
                'description'    => 'Capture your timeless luxury moments with Love Studios. Professional wedding photography, cinematography, and portrait services.',
                'keywords'       => 'wedding photography, love studios, luxury studio, candid photos, pre-wedding shoot',
                'canonical_url'  => url('/'),
                'og_title'       => 'Love Studios — Timeless Photography',
                'og_description' => 'Luxury wedding & event photography studio.',
            ]
        );

        // Ensure homepage SEO title is Love Studios
        if ($selectedPage === 'home' && str_contains($seo->title, 'Moments Studio')) {
            $seo->update([
                'title' => 'Love Studios — Premium Wedding & Event Photography',
                'og_title' => 'Love Studios — Timeless Photography',
            ]);
        }

        $allMetas = SeoMeta::all()->keyBy('page');

        return view('admin.seo.index', compact('pages', 'selectedPage', 'seo', 'allMetas'));
    }

    public function update(Request $request, $page)
    {
        $seo = SeoMeta::firstOrCreate(['page' => $page]);

        $seo->update([
            'title'               => $request->title,
            'description'         => $request->description,
            'keywords'            => $request->keywords,
            'canonical_url'       => $request->canonical_url,
            'og_title'            => $request->og_title,
            'og_description'      => $request->og_description,
            'og_image'            => $request->og_image,
            'twitter_title'       => $request->twitter_title,
            'twitter_description' => $request->twitter_description,
            'twitter_image'       => $request->twitter_image,
            'schema_markup'       => $request->schema_markup,
            'head_scripts'        => $request->head_scripts,
        ]);

        return redirect()->route('admin.seo.index', ['page' => $page])->with('success', 'SEO meta data updated successfully for [' . ucfirst($page) . '] page!');
    }
}
