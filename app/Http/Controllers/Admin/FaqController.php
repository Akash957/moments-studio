<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('category')->latest()->paginate(15);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $categories = FaqCategory::all();
        return view('admin.faqs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        Faq::create([
            'category_id' => $request->category_id,
            'question'    => $request->question,
            'answer'      => $request->answer,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ item added successfully.');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $categories = FaqCategory::all();
        return view('admin.faqs.create', compact('faq', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        $faq->update([
            'category_id' => $request->category_id,
            'question'    => $request->question,
            'answer'      => $request->answer,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return back()->with('success', 'FAQ deleted successfully.');
    }
}
