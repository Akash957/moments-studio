<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount('services')->orderBy('sort_order')->paginate(15);
        return view('admin.service_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        ServiceCategory::create([
            'name'        => $request->name,
            'slug'        => ServiceCategory::generateUniqueSlug($request->name),
            'icon'        => $request->icon ?? 'fas fa-camera',
            'description' => $request->description,
            'image'       => $request->image,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Service category created successfully.');
    }

    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.service_categories.create', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => ServiceCategory::generateUniqueSlug($request->name, $category->id),
            'icon'        => $request->icon,
            'description' => $request->description,
            'image'       => $request->image,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.service-categories.index')->with('success', 'Service category updated successfully.');
    }

    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Service category deleted successfully.');
    }
}
