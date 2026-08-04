<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('features')->get();
        return view('frontend.packages', compact('packages'));
    }

    public function show(string $slug)
    {
        $package = Package::where('slug', $slug)->orWhere('id', $slug)->with('features')->firstOrFail();
        return view('frontend.package-detail', compact('package'));
    }
}
