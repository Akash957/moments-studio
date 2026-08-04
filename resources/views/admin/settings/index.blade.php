@extends('layouts.admin')
@php use App\Models\Setting; @endphp

@section('title', 'Moments Studio Settings')
@section('page_title', 'Global Website & Studio Configuration')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-sliders-h mr-2"></i> Moments Studio Brand & Settings Directory</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Brand Logo & Favicon Section -->
            <h5 class="text-gold border-bottom pb-2 mb-4"><i class="fas fa-crown mr-2"></i> Brand Logo & Favicon Assets</h5>
            <div class="row mb-4 bg-dark p-3 rounded border border-secondary">
                <div class="col-md-4 text-center border-right border-secondary mb-3 mb-md-0">
                    <label class="form-label font-weight-bold d-block text-gold">Primary Studio Logo</label>
                    <img src="{{ Setting::get('site_logo', asset('assets/images/logo.png')) }}" alt="Primary Logo" class="img-fluid rounded-circle border border-warning shadow mb-2" style="max-height:110px;width:110px;object-fit:cover;">
                    <input type="file" name="site_logo_file" class="form-control form-control-sm mb-2" accept="image/*">
                    <input type="text" name="site_logo" class="form-control" value="{{ Setting::get('site_logo', asset('assets/images/logo.png')) }}" placeholder="Or paste Logo Image URL">
                </div>
                <div class="col-md-4 text-center border-right border-secondary mb-3 mb-md-0">
                    <label class="form-label font-weight-bold d-block text-gold">Light Variant Logo</label>
                    <img src="{{ Setting::get('site_logo_light', asset('assets/images/logo-light.png')) }}" alt="Light Logo" class="img-fluid rounded-circle border border-warning shadow mb-2" style="max-height:110px;width:110px;object-fit:cover;">
                    <input type="file" name="site_logo_light_file" class="form-control form-control-sm mb-2" accept="image/*">
                    <input type="text" name="site_logo_light" class="form-control" value="{{ Setting::get('site_logo_light', asset('assets/images/logo-light.png')) }}" placeholder="Or paste Light Logo Image URL">
                </div>
                <div class="col-md-4 text-center">
                    <label class="form-label font-weight-bold d-block text-gold">Browser Favicon</label>
                    <img src="{{ Setting::get('site_favicon', asset('assets/images/favicon.png')) }}" alt="Favicon" class="img-fluid rounded-circle border border-warning shadow mb-2" style="max-height:110px;width:110px;object-fit:cover;">
                    <input type="file" name="site_favicon_file" class="form-control form-control-sm mb-2" accept="image/*">
                    <input type="text" name="site_favicon" class="form-control" value="{{ Setting::get('site_favicon', asset('assets/images/favicon.png')) }}" placeholder="Or paste Favicon Image URL">
                </div>
            </div>

            <div class="row">
                <!-- General Info -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-building mr-2"></i> General Info</h5>
                    <div class="form-group mb-3">
                        <label>Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="{{ Setting::get('site_name', 'Moments Studio') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Site Tagline</label>
                        <input type="text" name="site_tagline" class="form-control" value="{{ Setting::get('site_tagline', 'Capturing Eternal Moments & Luxury Stories') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Contact Email</label>
                        <input type="email" name="site_email" class="form-control" value="{{ Setting::get('site_email', 'info@momentsstudio.in') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Phone Number</label>
                        <input type="text" name="site_phone" class="form-control" value="{{ Setting::get('site_phone', '+91 98765 43210') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>WhatsApp Number</label>
                        <input type="text" name="site_whatsapp" class="form-control" value="{{ Setting::get('site_whatsapp', '919876543210') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Studio Address</label>
                        <textarea name="site_address" class="form-control" rows="2">{{ Setting::get('site_address', '123, Diamond Street, New York, USA') }}</textarea>
                    </div>
                </div>

                <!-- Homepage About Us Section -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-address-card mr-2"></i> Homepage About Us Section</h5>
                    <div class="form-group mb-3">
                        <label>About Heading Title</label>
                        <input type="text" name="home_about_title" class="form-control" value="{{ Setting::get('home_about_title', 'We Don\'t Just Take Photos, We Create Masterpieces') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>About Paragraph Text</label>
                        <textarea name="home_about_text" class="form-control" rows="3">{{ Setting::get('home_about_text', 'At Moments Studio, we believe every moment is unique and deserves to be remembered forever. Our passion is to turn your special moments into timeless stories.') }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>About Main Image URL</label>
                        <input type="text" name="home_about_image" class="form-control" value="{{ Setting::get('home_about_image', 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800') }}">
                    </div>
                </div>

                <!-- Homepage Stats Counters -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-chart-line mr-2"></i> Homepage Stats Counters</h5>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label>Years Experience</label>
                            <input type="number" name="stat_experience" class="form-control" value="{{ Setting::get('stat_experience', 12) }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label>Weddings Completed</label>
                            <input type="number" name="stat_weddings" class="form-control" value="{{ Setting::get('stat_weddings', 850) }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label>Happy Clients</label>
                            <input type="number" name="stat_clients" class="form-control" value="{{ Setting::get('stat_clients', 1250) }}">
                        </div>
                        <div class="col-6 mb-3">
                            <label>Awards Won</label>
                            <input type="number" name="stat_awards" class="form-control" value="{{ Setting::get('stat_awards', 45) }}">
                        </div>
                    </div>
                </div>

                <!-- Social Media & Links -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-share-alt mr-2"></i> Social Media Links</h5>
                    <div class="form-group mb-3">
                        <label>Instagram URL</label>
                        <input type="url" name="social_instagram" class="form-control" value="{{ Setting::get('social_instagram', 'https://instagram.com/lovestudios') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Facebook URL</label>
                        <input type="url" name="social_facebook" class="form-control" value="{{ Setting::get('social_facebook', 'https://facebook.com/lovestudios') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>YouTube URL</label>
                        <input type="url" name="social_youtube" class="form-control" value="{{ Setting::get('social_youtube', 'https://youtube.com/@lovestudios') }}">
                    </div>
                    <div class="form-group mb-3">
                        <label>Google Maps Embed URL</label>
                        <textarea name="google_maps_embed" class="form-control" rows="2">{{ Setting::get('google_maps_embed') }}</textarea>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-gold btn-lg"><i class="fas fa-save mr-2"></i> Save All Moments Studio Settings</button>
        </form>
    </div>
</div>
@endsection
