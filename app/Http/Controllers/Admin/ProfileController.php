<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.common.index', ['title' => 'My Profile', 'items' => collect([])]);
    }

    public function update(Request $request)
    {
        return back()->with('success', 'Profile updated.');
    }
}
