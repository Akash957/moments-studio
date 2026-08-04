<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $team = TeamMember::latest()->paginate(15);
        return view('admin.team.index', compact('team'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'required|string|max:100',
        ]);

        TeamMember::create([
            'name'         => $request->name,
            'designation'  => $request->designation,
            'bio'          => $request->bio,
            'image'        => $request->image,
            'instagram'    => $request->instagram,
            'facebook'     => $request->facebook,
            'sort_order'   => $request->sort_order ?? 0,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('admin.team.create', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);
        $request->validate([
            'name'        => 'required|string|max:100',
            'designation' => 'required|string|max:100',
        ]);

        $member->update([
            'name'         => $request->name,
            'designation'  => $request->designation,
            'bio'          => $request->bio,
            'image'        => $request->image,
            'instagram'    => $request->instagram,
            'facebook'     => $request->facebook,
            'sort_order'   => $request->sort_order ?? 0,
            'is_active'    => $request->has('is_active'),
        ]);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();
        return back()->with('success', 'Team member deleted successfully.');
    }
}
