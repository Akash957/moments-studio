<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->latest()->paginate(15);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::all();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'starting_price' => 'nullable|numeric',
            'image_file'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->except(['_token', 'image_file']);
        $data['slug'] = Service::generateUniqueSlug($request->name);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active']   = $request->has('is_active');

        // Handle Image File Upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            $destinationPath = public_path('uploads/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['featured_image'] = asset('uploads/services/' . $filename);
        }

        // Process Includes from newline text
        if (!empty($request->includes_input)) {
            $data['includes'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->includes_input)))));
        }

        // Process Time Slots from newline text
        if (!empty($request->time_slots_input)) {
            $timeSlots = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->time_slots_input)))));
            $data['features'] = ['time_slots' => $timeSlots];
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $categories = ServiceCategory::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:100',
            'starting_price' => 'nullable|numeric',
            'image_file'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = $request->except(['_token', '_method', 'image_file', 'time_slots_input', 'includes_input']);
        
        if ($request->name !== $service->name || empty($service->slug)) {
            $data['slug'] = Service::generateUniqueSlug($request->name, $service->id);
        }

        $data['is_featured'] = $request->has('is_featured');
        $data['is_active']   = $request->has('is_active');

        // Handle Image File Upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . \Illuminate\Support\Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
            
            $destinationPath = public_path('uploads/services');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['featured_image'] = asset('uploads/services/' . $filename);
        }

        // Process Includes from newline text
        if (isset($request->includes_input)) {
            $data['includes'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->includes_input)))));
        }

        // Process Time Slots from newline text
        if (isset($request->time_slots_input)) {
            $timeSlots = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->time_slots_input)))));
            $existingFeatures = $service->features ?? [];
            if (!is_array($existingFeatures)) {
                $existingFeatures = [];
            }
            $existingFeatures['time_slots'] = $timeSlots;
            $data['features'] = $existingFeatures;
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return back()->with('success', 'Service deleted successfully.');
    }

    public function reorder(Request $request)
    {
        return response()->json(['success' => true]);
    }
}
