<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $targetDir = public_path('assets/images');
        $bgSource = 'C:/Users/appsdev/.gemini/antigravity-ide/brain/33d9b202-04a5-43fc-8a98-b61d3c9289a1/media__1785568992637.png';
        if (file_exists($bgSource)) {
            @copy($bgSource, $targetDir . '/admin-bg.jpg');
        }

        // Default logo fallback if not present in DB
        if (!Setting::get('site_logo')) {
            Setting::set('site_logo', asset('assets/images/logo.png'));
        }
        if (!Setting::get('site_logo_light')) {
            Setting::set('site_logo_light', asset('assets/images/logo-light.png'));
        }
        if (!Setting::get('site_favicon')) {
            Setting::set('site_favicon', asset('assets/images/favicon.png'));
        }

        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', 'site_logo_file', 'site_logo_light_file', 'site_favicon_file']);

        $uploadDir = public_path('assets/images/uploads');
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        // Handle Primary Logo Upload
        if ($request->hasFile('site_logo_file') && $request->file('site_logo_file')->isValid()) {
            $file = $request->file('site_logo_file');
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $logoUrl = asset('assets/images/uploads/' . $filename);
            Setting::set('site_logo', $logoUrl);
            unset($inputs['site_logo']);
        }

        // Handle Light Logo Upload
        if ($request->hasFile('site_logo_light_file') && $request->file('site_logo_light_file')->isValid()) {
            $file = $request->file('site_logo_light_file');
            $filename = 'logo_light_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $logoUrl = asset('assets/images/uploads/' . $filename);
            Setting::set('site_logo_light', $logoUrl);
            unset($inputs['site_logo_light']);
        }

        // Handle Favicon Upload
        if ($request->hasFile('site_favicon_file') && $request->file('site_favicon_file')->isValid()) {
            $file = $request->file('site_favicon_file');
            $filename = 'favicon_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $faviconUrl = asset('assets/images/uploads/' . $filename);
            Setting::set('site_favicon', $faviconUrl);
            unset($inputs['site_favicon']);
        }

        // Save all other text settings
        foreach ($inputs as $key => $value) {
            Setting::set($key, $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Moments Studio settings and brand logos updated successfully!');
    }
}
