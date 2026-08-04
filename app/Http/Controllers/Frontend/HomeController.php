<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Award;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\HeroSlider;
use App\Models\InstagramFeed;
use App\Models\Package;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        Cache::forget('home_page_data');

        $data = [
            'heroSliders'     => HeroSlider::where('is_active', true)->orderBy('sort_order')->get(),
            'services'        => Service::where('is_active', true)->limit(8)->get(),
            'featuredGallery' => Gallery::where('is_active', true)->with('category')->limit(12)->get(),
            'featuredAlbums'  => Album::with(['category', 'images'])->limit(3)->get(),
            'packages'        => Package::where('is_active', true)->with(['features', 'service'])->orderBy('sort_order')->get(),
            'testimonials'    => Testimonial::where('is_approved', true)->limit(6)->get(),
            'awards'          => Award::latest()->limit(6)->get(),
            'latestBlogs'     => Blog::with(['category', 'author'])->latest()->limit(3)->get(),
            'instagramFeeds'  => InstagramFeed::active()->ordered()->get(),
            'stats'           => [
                'experience' => Setting::get('stat_experience', 12),
                'weddings'   => Setting::get('stat_weddings', 850),
                'clients'    => Setting::get('stat_clients', 1250),
                'awards'     => Setting::get('stat_awards', 28),
            ],
            'aboutSettings'   => Setting::getGroup('homepage'),
        ];

        return view('frontend.home', $data);
    }
}
