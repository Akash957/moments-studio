<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Setting;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function awards()
    {
        $awards = Award::latest()->get();
        return view('frontend.pages.awards', compact('awards'));
    }

    public function team()
    {
        $team = TeamMember::all();
        return view('frontend.pages.team', compact('team'));
    }

    public function faq()
    {
        $categories = FaqCategory::with('faqs')->get();
        return view('frontend.pages.faq', compact('categories'));
    }

    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    public function terms()
    {
        return view('frontend.pages.terms');
    }

    public function sitemap()
    {
        $services = \App\Models\Service::all();
        $albums   = \App\Models\Album::all();
        $blogs    = \App\Models\Blog::all();
        return response()->view('frontend.sitemap', compact('services', 'albums', 'blogs'))
            ->header('Content-Type', 'application/xml');
    }

    public function search(Request $request)
    {
        $query  = $request->get('q', '');
        $results = [];

        if (strlen($query) >= 2) {
            $services = \App\Models\Service::where('name', 'like', "%{$query}%")
                ->limit(5)->get()->map(fn($s) => ['type' => 'Service', 'title' => $s->name, 'url' => route('services.show', $s->slug)]);

            $blogs = \App\Models\Blog::where('title', 'like', "%{$query}%")
                ->limit(5)->get()->map(fn($b) => ['type' => 'Blog', 'title' => $b->title, 'url' => route('blog.show', $b->slug)]);

            $results = $services->merge($blogs);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(compact('results'));
        }

        return view('frontend.search', compact('query', 'results'));
    }
}
