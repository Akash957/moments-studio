<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Auto-copy logo image if present in brain artifacts
        $sourceImage = 'C:/Users/appsdev/.gemini/antigravity-ide/brain/33d9b202-04a5-43fc-8a98-b61d3c9289a1/moments_studio_logo_1785567746920.png';
        $targetDir = public_path('assets/images');
        
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0777, true);
        }

        if (file_exists($sourceImage)) {
            @copy($sourceImage, $targetDir . '/logo.png');
            @copy($sourceImage, $targetDir . '/logo-light.png');
            @copy($sourceImage, $targetDir . '/favicon.png');
        }

        // Set default logo settings
        Setting::set('site_logo', asset('assets/images/logo.png'));
        Setting::set('site_logo_light', asset('assets/images/logo-light.png'));
        Setting::set('site_favicon', asset('assets/images/favicon.png'));

        if (Setting::get('site_name') !== 'Moments Studio') {
            Setting::set('site_name', 'Moments Studio');
            Setting::set('site_tagline', 'Capturing Eternal Moments & Luxury Stories');
            Setting::set('site_email', 'info@momentsstudio.in');
        }

        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token']);

        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Love Studios settings and logos updated successfully!');
    }
}
