<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BookingRequest;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $services = Service::active()->get();
        $packages = Package::active()->with('features')->get();

        $selectedPackage = $request->package_id
            ? Package::find($request->package_id)
            : null;

        return view('frontend.booking', compact('services', 'packages', 'selectedPackage'));
    }

    public function store(BookingRequest $request)
    {
        $data = $request->validated();

        // Handle reference image uploads
        if ($request->hasFile('reference_images')) {
            $images = [];
            foreach ($request->file('reference_images') as $file) {
                $path = $file->store('bookings/references', 'public');
                $images[] = $path;
            }
            $data['reference_images'] = $images;
        }

        // Prevent rapid duplicate submission within 10 seconds
        $existingRecent = Booking::where('client_email', $data['client_email'])
            ->where('event_date', $data['event_date'])
            ->where('created_at', '>=', now()->subSeconds(10))
            ->first();

        if ($existingRecent) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success'        => true,
                    'booking_number' => $existingRecent->booking_number,
                    'message'        => 'Booking submitted successfully!',
                ]);
            }
            return redirect()->route('booking.success', $existingRecent->booking_number);
        }

        $booking = Booking::create($data);

        // Dispatch notification jobs
        try {
            if (class_exists(\App\Jobs\SendBookingConfirmation::class)) {
                \App\Jobs\SendBookingConfirmation::dispatch($booking);
            }
            if (class_exists(\App\Jobs\SendBookingAdminAlert::class)) {
                \App\Jobs\SendBookingAdminAlert::dispatch($booking);
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Booking job dispatch notice: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'        => true,
                'booking_number' => $booking->booking_number,
                'message'        => 'Booking submitted successfully!',
            ]);
        }

        return redirect()->route('booking.success', $booking->booking_number)
            ->with('success', 'Your booking has been submitted! Booking ID: ' . $booking->booking_number);
    }

    public function success(string $bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)->firstOrFail();
        return view('frontend.booking-success', compact('booking'));
    }
}
