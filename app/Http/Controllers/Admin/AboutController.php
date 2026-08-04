<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = [
            'home_about_title'    => Setting::get('home_about_title', "We Don't Just Take Photos,\nWe Create Masterpieces"),
            'home_about_text'     => Setting::get('home_about_text', 'At Moments Studio, we believe every moment is unique and deserves to be remembered forever. Our passion is to turn your special moments into timeless stories.'),
            'home_about_image'    => Setting::get('home_about_image', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800'),
            'home_about_accent'   => Setting::get('home_about_accent', 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400'),
            'home_about_signature'=> Setting::get('home_about_signature', 'Moments Studio'),
            'stat_experience'     => Setting::get('stat_experience', 12),
            'stat_weddings'       => Setting::get('stat_weddings', 850),
            'stat_clients'        => Setting::get('stat_clients', 1250),
            'stat_awards'         => Setting::get('stat_awards', 28),
            'feature_1'           => Setting::get('feature_1', 'Creative & Professional Team'),
            'feature_2'           => Setting::get('feature_2', 'High-End Equipment'),
            'feature_3'           => Setting::get('feature_3', '100% Client Satisfaction'),
            'feature_4'           => Setting::get('feature_4', 'Worldwide Available'),
            'our_mission'         => Setting::get('our_mission', 'To capture authentic emotions and preserve lifelong memories through world-class photography and cinematic storytelling.'),
            'our_vision'          => Setting::get('our_vision', 'To become the premier luxury wedding photography studio recognized globally for artistic excellence.'),
            'our_values'          => Setting::get('our_values', 'Authenticity, Artistic Precision, Client Delight, Passion & Timeless Aesthetics.'),
        ];

        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token']);

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'About Us & Brand Story updated successfully.');
    }
}
