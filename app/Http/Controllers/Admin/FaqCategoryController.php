<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryController extends Controller
{
    public function index()
    {
        $cats = FaqCategory::latest()->paginate(15);
        return view('admin.common.index', ['title' => 'FAQ Categories', 'items' => $cats]);
    }
}
