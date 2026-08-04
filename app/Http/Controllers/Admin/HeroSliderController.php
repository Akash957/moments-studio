<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'image' => 'required|string',
        ]);

        HeroSlider::create([
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'description'   => $request->description,
            'image'         => $request->image,
            'button_text'   => $request->button_text ?? 'Explore Gallery',
            'button_url'    => $request->button_url ?? route('gallery.index'),
            'button_text_2' => $request->button_text_2 ?? 'Book Now',
            'button_url_2'  => $request->button_url_2 ?? route('booking.create'),
            'is_active'     => $request->has('is_active'),
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Hero slide created successfully.');
    }

    public function edit($id)
    {
        $slider = HeroSlider::findOrFail($id);
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        $slider = HeroSlider::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:200',
            'image' => 'required|string',
        ]);

        $slider->update([
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'description'   => $request->description,
            'image'         => $request->image,
            'button_text'   => $request->button_text,
            'button_url'    => $request->button_url,
            'button_text_2' => $request->button_text_2,
            'button_url_2'  => $request->button_url_2,
            'is_active'     => $request->has('is_active'),
            'sort_order'    => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Hero slide updated successfully.');
    }

    public function destroy($id)
    {
        $slider = HeroSlider::findOrFail($id);
        $slider->delete();
        return back()->with('success', 'Hero slide deleted successfully.');
    }

    public function reorder(Request $request)
    {
        return response()->json(['success' => true]);
    }
}
