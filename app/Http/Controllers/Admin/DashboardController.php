<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings'  => Booking::count(),
            'pending_bookings'=> Booking::pending()->count(),
            'total_enquiries' => Enquiry::count(),
            'new_enquiries'   => Enquiry::where('status', 'new')->count(),
            'total_photos'    => Gallery::count(),
            'total_albums'    => Album::count(),
            'total_services'  => Service::count(),
            'total_blogs'     => Blog::count(),
        ];

        $recentBookings  = Booking::latest()->limit(5)->get();
        $recentEnquiries = Enquiry::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentEnquiries'));
    }
}
