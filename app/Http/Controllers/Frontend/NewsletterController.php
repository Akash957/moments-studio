<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->status === 'unsubscribed') {
                $existing->update(['status' => 'active', 'unsubscribed_at' => null]);
                return response()->json(['success' => true, 'message' => 'Welcome back! You have been re-subscribed.']);
            }
            return response()->json(['success' => false, 'message' => 'You are already subscribed!'], 422);
        }

        NewsletterSubscriber::create([
            'email'      => $request->email,
            'name'       => $request->name,
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true, 'message' => 'Thank you for subscribing! 🎉']);
    }

    public function unsubscribe(string $token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->first();

        if (!$subscriber) {
            return view('frontend.newsletter-unsubscribe', ['error' => 'Invalid unsubscribe link.']);
        }

        $subscriber->update([
            'status'           => 'unsubscribed',
            'unsubscribed_at'  => now(),
        ]);

        return view('frontend.newsletter-unsubscribe', ['success' => true]);
    }
}
