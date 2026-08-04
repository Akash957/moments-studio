<?php

use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AlbumController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\TestimonialController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Serve Storage Assets Directly (Bypasses 403 Forbidden Symlink Issues)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        $fullPath = public_path('uploads/' . $path);
    }
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

// =========================================
// Authentication Routes
// =========================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/admin/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =========================================
// Frontend — Public Routes
// =========================================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Services
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/',        [ServiceController::class, 'index'])->name('index');
    Route::get('/{slug}',  [ServiceController::class, 'show'])->name('show');
});

// Gallery
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/',         [GalleryController::class, 'index'])->name('index');
    Route::get('/load',     [GalleryController::class, 'ajaxLoad'])->name('load');
});

// Albums
Route::prefix('albums')->name('albums.')->group(function () {
    Route::get('/',        [AlbumController::class, 'index'])->name('index');
    Route::get('/{slug}',  [AlbumController::class, 'show'])->name('show');
});

// Videos
Route::prefix('videos')->name('videos.')->group(function () {
    Route::get('/',        [VideoController::class, 'index'])->name('index');
    Route::get('/{slug}',  [VideoController::class, 'show'])->name('show');
});

// Packages
Route::prefix('packages')->name('packages.')->group(function () {
    Route::get('/',        [PackageController::class, 'index'])->name('index');
    Route::get('/{slug}',  [PackageController::class, 'show'])->name('show');
});

// Testimonials
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

// Awards
Route::get('/awards', [PageController::class, 'awards'])->name('awards.index');

// Team
Route::get('/team', [PageController::class, 'team'])->name('team.index');

// FAQ
Route::get('/faq', [PageController::class, 'faq'])->name('faq.index');

// Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',        [BlogController::class, 'index'])->name('index');
    Route::get('/{slug}',  [BlogController::class, 'show'])->name('show');
    Route::post('/comment',[BlogController::class, 'comment'])->name('comment');
});

// Booking
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/',            [BookingController::class, 'create'])->name('create');
    Route::post('/',           [BookingController::class, 'store'])->name('store');
    Route::get('/success/{booking_number}', [BookingController::class, 'success'])->name('success');
});

// Contact
Route::get('/contact',  [ContactController::class, 'index'])->name('contact');
Route::post('/enquiry', [ContactController::class, 'store'])->name('enquiry.store');

// Newsletter
Route::post('/newsletter/subscribe',            [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{token}',   [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Static Pages
Route::get('/privacy-policy',    [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-conditions',  [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml',       [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/search',            [PageController::class, 'search'])->name('search');

// =========================================
// Admin Routes — Protected
// =========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
    });

    // Hero Sliders
    Route::resource('sliders', \App\Http\Controllers\Admin\HeroSliderController::class);
    Route::post('sliders/reorder', [\App\Http\Controllers\Admin\HeroSliderController::class, 'reorder'])->name('sliders.reorder');

    // About Section
    Route::get('about', [\App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
    Route::post('about', [\App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');

    // Services
    Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
    Route::post('services/reorder', [\App\Http\Controllers\Admin\ServiceController::class, 'reorder'])->name('services.reorder');
    Route::resource('service-categories', \App\Http\Controllers\Admin\ServiceCategoryController::class);

    // Gallery
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
    Route::post('gallery/bulk', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkAction'])->name('gallery.bulk');

    // Albums
    Route::resource('albums', \App\Http\Controllers\Admin\AlbumController::class);

    // Videos
    Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class);

    // Packages
    Route::resource('packages', \App\Http\Controllers\Admin\PackageController::class);

    // Testimonials
    Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
    Route::patch('testimonials/{testimonial}/approve', [\App\Http\Controllers\Admin\TestimonialController::class, 'approve'])->name('testimonials.approve');

    // Awards
    Route::resource('awards', \App\Http\Controllers\Admin\AwardController::class);

    // Team
    Route::resource('team', \App\Http\Controllers\Admin\TeamController::class);

    // Blog
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);

    // FAQs
    Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);
    Route::resource('faq-categories', \App\Http\Controllers\Admin\FaqCategoryController::class);

    // Instagram Feed
    Route::resource('instagram-feeds', \App\Http\Controllers\Admin\InstagramFeedController::class);
    Route::post('instagram-feeds/settings', [\App\Http\Controllers\Admin\InstagramFeedController::class, 'updateSettings'])->name('instagram-feeds.settings');

    // Bookings
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::patch('bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::get('bookings/export', [\App\Http\Controllers\Admin\BookingController::class, 'export'])->name('bookings.export');

    // Enquiries
    Route::resource('enquiries', \App\Http\Controllers\Admin\EnquiryController::class)->only(['index', 'show', 'destroy']);
    Route::patch('enquiries/{enquiry}/status', [\App\Http\Controllers\Admin\EnquiryController::class, 'updateStatus'])->name('enquiries.status');

    // Quotes
    Route::resource('quotes', \App\Http\Controllers\Admin\QuoteController::class)->only(['index', 'show', 'destroy']);

    // Newsletter
    Route::get('newsletter', [\App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('newsletter.index');
    Route::post('newsletter/send', [\App\Http\Controllers\Admin\NewsletterController::class, 'send'])->name('newsletter.send');
    Route::delete('newsletter/{id}', [\App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::get('newsletter/export', [\App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('newsletter.export');

    // Media Manager
    Route::get('media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
    Route::post('media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
    Route::post('media/upload', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.upload');
    Route::delete('media/{id}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');

    // Users & Roles
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

    // SEO
    Route::get('seo', [\App\Http\Controllers\Admin\SeoController::class, 'index'])->name('seo.index');
    Route::post('seo/{page}', [\App\Http\Controllers\Admin\SeoController::class, 'update'])->name('seo.update');

    // Email Templates
    Route::resource('email-templates', \App\Http\Controllers\Admin\EmailTemplateController::class);
    Route::post('email-templates/preview', [\App\Http\Controllers\Admin\EmailTemplateController::class, 'preview'])->name('email-templates.preview');

    // Reports & Analytics
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/data', [\App\Http\Controllers\Admin\ReportController::class, 'data'])->name('reports.data');
    Route::get('reports/export/{type}', [\App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');

    // Activity Log
    Route::get('activity-log', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-log.index');

    // Profile
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
});

if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}
