<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:100',
            'review'      => 'required|string',
        ]);

        Testimonial::create([
            'client_name'      => $request->client_name,
            'wedding_location' => $request->wedding_location,
            'review'           => $request->review,
            'rating'           => $request->rating ?? 5.0,
            'is_featured'      => $request->has('is_featured'),
            'is_approved'      => true,
            'is_active'        => true,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $request->validate([
            'client_name' => 'required|string|max:100',
            'review'      => 'required|string',
        ]);

        $testimonial->update([
            'client_name'      => $request->client_name,
            'wedding_location' => $request->wedding_location,
            'review'           => $request->review,
            'rating'           => $request->rating,
            'is_featured'      => $request->has('is_featured'),
            'is_approved'      => $request->has('is_approved'),
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function approve($id)
    {
        Testimonial::findOrFail($id)->update(['is_approved' => true]);
        return back()->with('success', 'Testimonial approved successfully.');
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimonial deleted successfully.');
    }
}
