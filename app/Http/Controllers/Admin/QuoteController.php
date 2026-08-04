<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function index()
    {
        $quotes = Quote::latest()->paginate(15);
        return view('admin.common.index', ['title' => 'Quotes', 'items' => $quotes]);
    }

    public function destroy($id)
    {
        Quote::findOrFail($id)->delete();
        return back()->with('success', 'Quote deleted.');
    }
}
