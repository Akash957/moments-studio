<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\EnquiryRequest;
use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact', [
            'seoTitle'       => 'Contact Moments Studio — Book Your Photography Session',
            'seoDescription' => 'Get in touch with Moments Studio for wedding photography bookings, quotes, and enquiries.',
            'seoPage'        => 'contact',
        ]);
    }

    public function store(EnquiryRequest $request)
    {
        $enquiry = Enquiry::create(array_merge($request->validated(), [
            'source'     => $request->input('source', 'contact_form'),
            'page_url'   => $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]));

        // Dispatch notification job
        try {
            \App\Jobs\SendEnquiryNotification::dispatch($enquiry);
        } catch (\Exception $e) {
            // Silently fail - don't break the UX
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Your enquiry has been sent successfully!']);
        }

        return back()->with('success', 'Thank you! Your message has been sent. We will get back to you within 24 hours.');
    }
}
