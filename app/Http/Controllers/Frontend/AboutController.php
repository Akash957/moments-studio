<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\TeamMember;
use App\Models\Testimonial;

class AboutController extends Controller
{
    public function index()
    {
        $data = [
            'team'         => TeamMember::active()->get(),
            'awards'       => Award::active()->get(),
            'testimonials' => Testimonial::active()->limit(4)->get(),
            'stats'        => [
                'experience' => Setting::get('stat_experience', 12),
                'weddings'   => Setting::get('stat_weddings', 850),
                'clients'    => Setting::get('stat_clients', 1250),
                'awards'     => Setting::get('stat_awards', 28),
            ],
            'seoTitle'      => 'About Moments Studio — Premium Wedding Photography Team',
            'seoDescription'=> 'Learn about the passionate team behind Moments Studio. Over 12 years of wedding photography experience.',
            'seoPage'       => 'about',
        ];

        return view('frontend.about', $data);
    }
}
