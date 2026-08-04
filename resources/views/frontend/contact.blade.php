@extends('layouts.app')
@php
    use App\Models\Setting;
    $seoTitle = 'Contact Us — ' . Setting::get('site_name', 'Moments Studio') . ' Wedding Photography';
    $seoDescription = 'Get in touch with ' . Setting::get('site_name', 'Moments Studio') . ' to discuss your wedding photography requirements, request custom quotes, or schedule a consultation.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Get In Touch</span>
            <h1 class="page-hero-title">Contact Our Studio</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Contact</span>
            </nav>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="section section-dark">
    <div class="container">
        <div class="row g-5">

            {{-- Info Cards --}}
            <div class="col-lg-5" data-aos="fade-right">
                <span class="section-label">Reach Out</span>
                <h2 class="section-title mb-4">Let's Create Magic Together</h2>
                <p style="color:var(--color-gray);line-height:1.8;" class="mb-4">
                    Have questions about dates, pricing, or locations? Send us a message or connect directly on WhatsApp. We reply within 24 hours.
                </p>

                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-lg);border:1px solid rgba(201,169,110,0.15);">
                        <div style="width:50px;height:50px;background:var(--color-gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--color-gold);font-size:1.25rem;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;color:var(--color-gray);text-transform:uppercase;letter-spacing:0.1em;">Call Us Directly</div>
                            <a href="tel:{{ Setting::get('site_phone', '+919876543210') }}" style="font-family:var(--font-primary);font-size:1.125rem;color:var(--color-white);font-weight:600;">
                                {{ Setting::get('site_phone', '+91 98765 43210') }}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-lg);border:1px solid rgba(201,169,110,0.15);">
                        <div style="width:50px;height:50px;background:rgba(37,211,102,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#25d366;font-size:1.25rem;">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;color:var(--color-gray);text-transform:uppercase;letter-spacing:0.1em;">Instant WhatsApp</div>
                            <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}" target="_blank" style="font-family:var(--font-primary);font-size:1.125rem;color:var(--color-white);font-weight:600;">
                                Chat on WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-lg);border:1px solid rgba(201,169,110,0.15);">
                        <div style="width:50px;height:50px;background:var(--color-gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--color-gold);font-size:1.25rem;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;color:var(--color-gray);text-transform:uppercase;letter-spacing:0.1em;">Email Us</div>
                            <a href="mailto:{{ Setting::get('site_email', 'info@lovestudios.in') }}" style="font-family:var(--font-primary);font-size:1.125rem;color:var(--color-white);font-weight:600;">
                                {{ Setting::get('site_email', 'info@lovestudios.in') }}
                            </a>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-lg);border:1px solid rgba(201,169,110,0.15);">
                        <div style="width:50px;height:50px;background:var(--color-gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--color-gold);font-size:1.25rem;">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <div style="font-size:0.75rem;color:var(--color-gray);text-transform:uppercase;letter-spacing:0.1em;">Studio Address</div>
                            <span style="font-family:var(--font-primary);font-size:1rem;color:var(--color-white);font-weight:600;">
                                {{ Setting::get('site_address', '123, Diamond Street, New York, USA') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-7" data-aos="fade-left">
                <div class="contact-card">
                    <span class="section-label">Send Message</span>
                    <h3 class="section-title mb-4" style="font-size:1.75rem;">Get a Free Quote & Consultation</h3>

                    <form action="{{ route('enquiry.store') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="+91 XXXXX XXXXX" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Event Type</label>
                                    <select name="event_type" class="form-control">
                                        <option value="">Select Event Type</option>
                                        <option value="wedding">Wedding Photography</option>
                                        <option value="pre-wedding">Pre Wedding Shoot</option>
                                        <option value="engagement">Engagement</option>
                                        <option value="maternity">Maternity Shoot</option>
                                        <option value="baby">Baby Shoot</option>
                                        <option value="corporate">Corporate</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Event Date</label>
                                    <input type="date" name="event_date" class="form-control" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">City / Location</label>
                                    <input type="text" name="subject" class="form-control" placeholder="e.g. Udaipur, Goa, Delhi">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Your Message *</label>
                                    <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your wedding plans, venue, vision..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary w-100" style="justify-content:center;">
                                    <i class="fas fa-paper-plane me-2"></i> Submit Inquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Google Maps — Compact Dark Luxury Embed --}}
<section style="padding:0;position:relative;background:#0a0a0a;">
    {{-- Section Header --}}
    <div class="container text-center" style="padding:50px 0 30px;">
        <span class="section-label">Find Us</span>
        <h2 class="section-title" style="font-size:1.75rem;">Visit Our Studio</h2>
        <p style="color:var(--color-gray);font-size:0.9rem;max-width:500px;margin:0 auto;">
            <i class="fas fa-map-marker-alt me-2" style="color:var(--color-gold);"></i>
            {{ Setting::get('site_address', 'Jaipur, Rajasthan, India') }}
        </p>
    </div>

    {{-- Map Container --}}
    <div style="position:relative;height:350px;overflow:hidden;border-top:2px solid rgba(201,169,110,0.3);border-bottom:2px solid rgba(201,169,110,0.3);">
        <iframe
            src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAPS_API_KEY', 'AIzaSyBc19C3Weqk97CdYInTUlLlbwBN_MqjLI8') }}&q={{ urlencode(Setting::get('site_address', 'Jaipur, Rajasthan, India')) }}&zoom=15&maptype=roadmap"
            width="100%"
            height="350"
            style="border:0;filter:grayscale(100%) invert(92%) contrast(0.9) brightness(0.7);display:block;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="{{ Setting::get('site_name', 'Moments Studio') }} Location"
        ></iframe>

        {{-- Overlay Gold Pin Badge --}}
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-120%);z-index:5;pointer-events:none;">
            <div style="width:44px;height:44px;background:var(--color-gold);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(201,169,110,0.6);border:2px solid #fff;">
                <i class="fas fa-camera" style="color:#fff;font-size:1rem;"></i>
            </div>
            <div style="width:0;height:0;border-left:8px solid transparent;border-right:8px solid transparent;border-top:10px solid var(--color-gold);margin:0 auto;"></div>
        </div>

        {{-- Bottom Info Strip --}}
        <div style="position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent, rgba(10,10,10,0.95));padding:25px 0 15px;z-index:4;">
            <div class="container d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:42px;height:42px;background:rgba(201,169,110,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-location-dot" style="color:var(--color-gold);"></i>
                    </div>
                    <div>
                        <div style="font-family:var(--font-primary);font-size:1rem;color:#fff;font-weight:600;">{{ Setting::get('site_name', 'Moments Studio') }}</div>
                        <div style="font-size:0.8rem;color:var(--color-gray);">{{ Setting::get('site_address', 'Jaipur, Rajasthan, India') }}</div>
                    </div>
                </div>
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(Setting::get('site_address', 'Jaipur, Rajasthan, India')) }}"
                   target="_blank"
                   class="btn btn-primary"
                   style="font-size:0.8rem;padding:8px 20px;">
                    <i class="fas fa-directions me-2"></i> Get Directions
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
