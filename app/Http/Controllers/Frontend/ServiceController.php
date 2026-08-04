<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services   = Service::where('is_active', true)->get();
        $categories = ServiceCategory::all();

        return view('frontend.services.index', compact('services', 'categories'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug', $slug)->orWhere('id', $slug)->first();

        if (!$service) {
            // Fallback 1: Try base slug without trailing numbers (e.g. wedding-photography-4 -> wedding-photography)
            $baseSlug = preg_replace('/-\d+$/', '', $slug);
            $service = Service::where('slug', $baseSlug)->first();
        }

        if (!$service) {
            // Fallback 2: Try matching by name
            $keyword = str_replace('-', ' ', preg_replace('/-\d+$/', '', $slug));
            $service = Service::where('name', 'LIKE', '%' . $keyword . '%')->first();
        }

        if (!$service) {
            // Fallback 3: Fallback to first available active service if no match
            $service = Service::active()->first();
        }

        if (!$service) {
            $related = collect();
            return view('frontend.services.show', ['service' => null, 'related' => $related]);
        }

        $related = Service::where('id', '!=', $service->id)
            ->active()
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('frontend.services.show', compact('service', 'related'));
    }
}
