@extends('layouts.app')
@php
    $seoTitle = $service ? ($service->name . ' — Moments Studio Photography') : 'Service Details — Moments Studio';
    $seoDescription = $service ? $service->short_description : 'Luxury photography and film services.';
@endphp

@section('content')

@if(!$service)
{{-- Empty State Screen --}}
<section class="section section-dark text-center py-5">
    <div class="container py-5">
        <div class="p-5 rounded-gold mx-auto shadow-lg" style="background:var(--color-dark-2);border:1px solid var(--color-gold-fade);max-width:650px;">
            <div style="font-size:3.5rem;color:var(--color-gold);" class="mb-3">
                <i class="fas fa-folder-open"></i>
            </div>
            <h2 class="font-primary text-white mb-3" style="font-size:2rem;">No Service Data Found</h2>
            <p class="text-gray mb-4" style="font-size:1.05rem;line-height:1.7;">The requested service is currently not available in our catalog. You can browse all available photography packages or contact our studio directly.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('services.index') }}" class="btn btn-gold"><i class="fas fa-camera me-2"></i> View All Services</a>
                <a href="{{ route('contact') }}" class="btn btn-outline-gold"><i class="fas fa-envelope me-2"></i> Contact Studio</a>
            </div>
        </div>
    </div>
</section>
@else

{{-- Luxury Hero Section --}}
<section class="page-hero" style="background-image: linear-gradient(180deg, rgba(15,15,15,0.7) 0%, rgba(15,15,15,0.95) 100%), url('{{ $service->featured_image_url }}'); background-size: cover; background-position: center; padding: 120px 0 80px;">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label" style="background: rgba(201, 169, 110, 0.15); border: 1px solid rgba(201, 169, 110, 0.4); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase; color: #c9a96e; display: inline-block; mb-3;">
                <i class="{{ $service->icon ?? 'fas fa-camera' }} me-2"></i> Premium Service
            </span>
            <h1 class="page-hero-title" style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 3.8rem); font-weight: 700; color: #ffffff; margin-top: 15px; margin-bottom: 20px;">
                {{ $service->name }}
            </h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}" class="text-gold text-decoration-none">Home</a></span>
                <span class="breadcrumb-separator mx-2 text-gray"><i class="fas fa-chevron-right" style="font-size:0.75rem;"></i></span>
                <span class="breadcrumb-item"><a href="{{ route('services.index') }}" class="text-gold text-decoration-none">Services</a></span>
                <span class="breadcrumb-separator mx-2 text-gray"><i class="fas fa-chevron-right" style="font-size:0.75rem;"></i></span>
                <span class="breadcrumb-item active text-white">{{ $service->name }}</span>
            </nav>
        </div>
    </div>
</section>

{{-- Content & Experience Section --}}
<section class="section section-dark py-5" style="background-color: #0f0f0f;">
    <div class="container">
        <div class="row g-5">
            {{-- Main Content Column --}}
            <div class="col-lg-8" data-aos="fade-right">
                
                {{-- Service Main Image --}}
                <div class="position-relative mb-5 overflow-hidden rounded-4 shadow-2xl" style="border: 1px solid rgba(201, 169, 110, 0.3);">
                    <img src="{{ $service->featured_image_url }}" alt="{{ $service->name }}" class="img-fluid w-100" style="max-height: 480px; object-fit: cover; width: 100%; transition: transform 0.5s ease;">
                    <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(0deg, rgba(15,15,15,0.95) 0%, transparent 100%); padding: 30px 25px 15px;">
                        <span class="badge bg-gold text-dark px-3 py-2 rounded-pill font-weight-bold" style="font-size: 0.85rem; letter-spacing: 1px;">
                            <i class="fas fa-star me-1"></i> TOP RATED LUXURY SERVICE
                        </span>
                    </div>
                </div>

                {{-- Tagline & Main Description --}}
                <div class="mb-5 p-4 rounded-4" style="background: rgba(22, 22, 22, 0.8); border: 1px solid rgba(201, 169, 110, 0.15);">
                    <h2 class="mb-3" style="font-family: 'Playfair Display', serif; font-size: 2.2rem; color: #ffffff; line-height: 1.3;">
                        {{ $service->tagline ?? $service->name }}
                    </h2>
                    <div style="font-family: var(--font-secondary); font-size: 1.15rem; color: #d0d0d0; line-height: 1.9;" class="service-description">
                        {!! nl2br(e($service->long_description ?? $service->short_description ?? 'We provide luxury photography and cinematic film coverage tailored to your special occasion. Every moment is captured with creative direction, state-of-the-art equipment, and professional color grading.')) !!}
                    </div>
                </div>

                {{-- Quick Feature Highlights Grid --}}
                <div class="row g-3 mb-5 text-center">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: rgba(30, 30, 30, 0.6); border: 1px solid rgba(201, 169, 110, 0.15);">
                            <i class="fas fa-camera text-gold fa-2x mb-2"></i>
                            <h5 class="text-white mb-1" style="font-size: 1rem;">Full 4K Raw + Edited</h5>
                            <small class="text-gray">High-resolution deliverables</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: rgba(30, 30, 30, 0.6); border: 1px solid rgba(201, 169, 110, 0.15);">
                            <i class="fas fa-award text-gold fa-2x mb-2"></i>
                            <h5 class="text-white mb-1" style="font-size: 1rem;">Senior Lead Crew</h5>
                            <small class="text-gray">Award-winning team</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3" style="background: rgba(30, 30, 30, 0.6); border: 1px solid rgba(201, 169, 110, 0.15);">
                            <i class="fas fa-bolt text-gold fa-2x mb-2"></i>
                            <h5 class="text-white mb-1" style="font-size: 1rem;">Express Turnaround</h5>
                            <small class="text-gray">Fast 30-day gallery access</small>
                        </div>
                    </div>
                </div>

                {{-- Dynamic What's Included Grid --}}
                @php
                    $includesList = [];
                    if (is_array($service->includes)) {
                        $includesList = array_filter($service->includes);
                    } elseif (is_string($service->includes) && !empty($service->includes)) {
                        $includesList = array_filter(array_map('trim', explode("\n", str_replace("\r", "", $service->includes))));
                    }
                    if (empty($includesList)) {
                        $includesList = [
                            'High-Resolution Edited Digital Photos',
                            'Full Raw Footage Access (Optional)',
                            'Professional Color Grading & Retouching',
                            'Private Password-Protected Online Gallery',
                            'Experienced Senior Lead Photographers',
                            'Fast 30-Day Delivery Timeline',
                        ];
                    }
                @endphp

                <div class="mb-5">
                    <h3 class="font-primary mb-4 text-gold d-flex align-items-center" style="font-size:1.75rem; font-family: 'Playfair Display', serif;">
                        <i class="fas fa-check-circle me-3 text-gold"></i> What's Included In This Service
                    </h3>
                    <div class="row g-3">
                        @foreach($includesList as $inc)
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 d-flex align-items-center h-100" style="background: rgba(25, 25, 25, 0.9); border: 1px solid rgba(201, 169, 110, 0.2); transition: all 0.3s ease;">
                                <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 38px; height: 38px; background: rgba(201, 169, 110, 0.15); color: #c9a96e; flex-shrink: 0;">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="text-white font-weight-500" style="font-size: 0.98rem; line-height: 1.4;">{{ $inc }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Custom Quote Banner --}}
                <div class="p-4 p-md-5 rounded-4 position-relative overflow-hidden" style="background: linear-gradient(135deg, rgba(30,26,18,0.95) 0%, rgba(18,18,18,0.95) 100%); border: 1px solid rgba(201,169,110,0.3);">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3 mb-md-0">
                            <h4 class="font-primary text-gold mb-2" style="font-family: 'Playfair Display', serif; font-size: 1.5rem;">Have Special Requirements?</h4>
                            <p class="text-gray mb-0" style="font-size: 0.95rem; line-height: 1.6;">We customize coverage, drone teams, and album options for your event location and schedule.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <button class="btn btn-gold px-4 py-2" @click="quoteOpen = true" style="border-radius: 30px;">
                                <i class="fas fa-paper-plane me-2"></i> Request Quote
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column --}}
            <div class="col-lg-4" data-aos="fade-left">
                <div class="contact-card sticky-top p-4 rounded-4 shadow-2xl" style="top: 100px; background: rgba(20, 20, 20, 0.95); border: 1px solid rgba(201, 169, 110, 0.3);">
                    <span class="section-label text-gold text-uppercase" style="letter-spacing: 2px; font-size: 0.75rem;">BOOKING & COVERAGE</span>
                    <h3 class="font-primary text-white my-2" style="font-family: 'Playfair Display', serif; font-size: 1.6rem;">Interested in {{ $service->name }}?</h3>
                    
                    @if($service->starting_price)
                    <div class="my-3 p-3 rounded-3 text-center" style="background: rgba(201, 169, 110, 0.08); border: 1px solid rgba(201, 169, 110, 0.2);">
                        <small class="text-gray text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 1px;">Starting Package Price</small>
                        <div style="font-family: 'Playfair Display', serif; font-size: 2.4rem; font-weight: 700; color: #c9a96e;">
                            ₹{{ number_format($service->starting_price, 0) }}
                        </div>
                        <small class="text-muted" style="font-size: 0.75rem;">Customized add-ons available upon request</small>
                    </div>
                    @endif

                    <div class="d-grid gap-2 my-4">
                        <a href="{{ route('booking.create', ['service_id' => $service->id]) }}" class="btn btn-primary py-3 rounded-3 font-weight-bold" style="justify-content: center; font-size: 1rem; letter-spacing: 0.5px;">
                            <i class="fas fa-calendar-check me-2"></i> Book This Service
                        </a>

                        <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}?text={{ urlencode('Hi, I am interested in ' . $service->name) }}" target="_blank" class="btn btn-outline-gold py-3 rounded-3 font-weight-bold" style="justify-content: center; font-size: 1rem;">
                            <i class="fab fa-whatsapp me-2 text-success"></i> Chat on WhatsApp
                        </a>
                    </div>

                    @if($related->count() > 0)
                    <hr style="border-color: rgba(201,169,110,0.2);" class="my-4">
                    <h4 class="font-primary text-gold mb-3" style="font-family: 'Playfair Display', serif; font-size: 1.15rem;">Explore Other Services</h4>
                    <div class="list-group list-group-flush bg-transparent">
                        @foreach($related as $rel)
                        <a href="{{ route('services.show', $rel->slug) }}" class="list-group-item bg-transparent text-white border-0 px-0 py-2 d-flex align-items-center justify-content-between text-decoration-none hover-gold">
                            <span class="d-flex align-items-center">
                                <i class="{{ $rel->icon ?? 'fas fa-camera' }} me-2 text-gold"></i>
                                <span style="font-size: 0.9rem;">{{ $rel->name }}</span>
                            </span>
                            <i class="fas fa-chevron-right text-gray" style="font-size: 0.75rem;"></i>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endif

@endsection
