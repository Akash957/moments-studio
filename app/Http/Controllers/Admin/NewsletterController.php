<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $subs = NewsletterSubscriber::latest()->paginate(20);
        return view('admin.newsletter.index', compact('subs'));
    }

    public function destroy($id)
    {
        NewsletterSubscriber::findOrFail($id)->delete();
        return back()->with('success', 'Subscriber deleted.');
    }

    public function send(Request $request)
    {
        return back()->with('success', 'Newsletter sent.');
    }

    public function export()
    {
        return back()->with('success', 'Subscribers exported.');
    }
}
