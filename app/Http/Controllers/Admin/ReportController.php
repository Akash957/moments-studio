<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.common.index', ['title' => 'Reports & Analytics', 'items' => collect([])]);
    }

    public function data()
    {
        return response()->json([]);
    }

    public function export($type)
    {
        return back()->with('success', 'Report exported.');
    }
}
