<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with(['service', 'features'])->latest()->paginate(15);
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $services = Service::all();
        return view('admin.packages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $imagePath = $request->image_url;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }

        $package = Package::create([
            'name'           => $request->name,
            'slug'           => Package::generateUniqueSlug($request->name),
            'service_id'     => $request->service_id,
            'tagline'        => $request->tagline,
            'description'    => $request->description,
            'image'          => $imagePath,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'badge'          => $request->badge,
            'hours'          => $request->hours ?? 8,
            'edited_photos'  => $request->edited_photos ?? 300,
            'photographers'  => $request->photographers ?? 2,
            'includes_video' => $request->has('includes_video'),
            'includes_drone' => $request->has('includes_drone'),
            'includes_album' => $request->has('includes_album'),
            'is_featured'    => $request->has('is_featured'),
            'is_popular'     => $request->has('is_popular'),
            'is_active'      => $request->has('is_active'),
        ]);

        if (!empty($request->features_input)) {
            $features = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->features_input)))));
            foreach ($features as $idx => $feat) {
                $package->features()->create([
                    'feature'     => $feat,
                    'is_included' => true,
                    'sort_order'  => $idx,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Pricing package created successfully.');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $services = Service::all();
        return view('admin.packages.edit', compact('package', 'services'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $request->validate([
            'name'  => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $imagePath = $package->image;
        if ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }

        $package->update([
            'name'           => $request->name,
            'service_id'     => $request->service_id,
            'tagline'        => $request->tagline,
            'description'    => $request->description,
            'image'          => $imagePath,
            'price'          => $request->price,
            'original_price' => $request->original_price,
            'badge'          => $request->badge,
            'hours'          => $request->hours,
            'edited_photos'  => $request->edited_photos,
            'photographers'  => $request->photographers,
            'includes_video' => $request->has('includes_video'),
            'includes_drone' => $request->has('includes_drone'),
            'includes_album' => $request->has('includes_album'),
            'is_featured'    => $request->has('is_featured'),
            'is_popular'     => $request->has('is_popular'),
            'is_active'      => $request->has('is_active'),
        ]);

        if (isset($request->features_input)) {
            $package->features()->delete();
            $features = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->features_input)))));
            foreach ($features as $idx => $feat) {
                $package->features()->create([
                    'feature'     => $feat,
                    'is_included' => true,
                    'sort_order'  => $idx,
                ]);
            }
        }

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return back()->with('success', 'Package deleted successfully.');
    }
}
