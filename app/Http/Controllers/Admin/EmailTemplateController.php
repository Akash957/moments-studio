<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        return view('admin.common.index', ['title' => 'Email Templates', 'items' => collect([])]);
    }

    public function preview(Request $request)
    {
        return response()->json(['html' => '']);
    }
}
