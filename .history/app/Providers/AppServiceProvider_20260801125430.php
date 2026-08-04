<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!class_exists('Setting')) {
            class_alias(\App\Models\Setting::class, 'Setting');
        }

        // Initial copy of default logo if assets/images does not contain logo yet
        $sourceImage = 'C:/Users/appsdev/.gemini/antigravity-ide/brain/33d9b202-04a5-43fc-8a98-b61d3c9289a1/moments_studio_logo_1785567746920.png';
        $targetDir = public_path('assets/images');

        if (file_exists($sourceImage)) {
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            if (!file_exists($targetDir . '/logo.png')) {
                @copy($sourceImage, $targetDir . '/logo.png');
            }
            if (!file_exists($targetDir . '/logo-light.png')) {
                @copy($sourceImage, $targetDir . '/logo-light.png');
            }
            if (!file_exists($targetDir . '/favicon.png')) {
                @copy($sourceImage, $targetDir . '/favicon.png');
            }
        // Copy luxury background image
        $bgSource = 'C:/Users/appsdev/.gemini/antigravity-ide/brain/33d9b202-04a5-43fc-8a98-b61d3c9289a1/media__1785568992637.png';
        if (file_exists($bgSource)) {
            if (!file_exists($targetDir)) {
                @mkdir($targetDir, 0777, true);
            }
            @copy($bgSource, $targetDir . '/admin-bg.jpg');
        }
    }
}
