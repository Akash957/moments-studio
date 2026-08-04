<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function index()
    {
        $awards = Award::latest()->paginate(15);
        return view('admin.awards.index', compact('awards'));
    }

    public function create()
    {
        return view('admin.awards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'year'  => 'required|integer',
        ]);

        Award::create([
            'title'         => $request->title,
            'year'          => $request->year,
            'organization'  => $request->organization,
            'description'   => $request->description,
            'image'         => $request->image,
            'is_featured'   => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.awards.index')->with('success', 'Award added successfully.');
    }

    public function edit($id)
    {
        $award = Award::findOrFail($id);
        return view('admin.awards.create', compact('award'));
    }

    public function update(Request $request, $id)
    {
        $award = Award::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:150',
            'year'  => 'required|integer',
        ]);

        $award->update([
            'title'         => $request->title,
            'year'          => $request->year,
            'organization'  => $request->organization,
            'description'   => $request->description,
            'image'         => $request->image,
            'is_featured'   => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.awards.index')->with('success', 'Award updated successfully.');
    }

    public function destroy($id)
    {
        $award = Award::findOrFail($id);
        $award->delete();
        return back()->with('success', 'Award deleted successfully.');
    }
}
