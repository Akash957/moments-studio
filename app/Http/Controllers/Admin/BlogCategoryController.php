<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $cats = BlogCategory::latest()->paginate(15);
        return view('admin.common.index', ['title' => 'Blog Categories', 'items' => $cats]);
    }
}
