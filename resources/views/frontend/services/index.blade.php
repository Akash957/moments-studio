@extends('layouts.app')
@php
    $seoTitle = 'Our Services — Luxury Wedding Photography & Films | Moments Studio';
    $seoDescription = 'Explore our luxury wedding photography services including wedding photography, pre-wedding shoot, engagement, maternity, candid photography, and drone videography.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: linear-gradient(180deg, rgba(15,15,15,0.7) 0%, rgba(15,15,15,0.95) 100%), url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920'); padding: 120px 0 80px;">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label" style="background: rgba(201, 169, 110, 0.15); border: 1px solid rgba(201, 169, 110, 0.4); padding: 6px 18px; border-radius: 50px; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase; color: #c9a96e; display: inline-block;">
                WHAT WE OFFER
            </span>
            <h1 class="page-hero-title my-3" style="font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 5vw, 3.8rem); font-weight: 700; color: #ffffff;">
                Our Luxury Services
            </h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}" class="text-gold text-decoration-none">Home</a></span>
                <span class="breadcrumb-separator mx-2 text-gray"><i class="fas fa-chevron-right" style="font-size:0.75rem;"></i></span>
                <span class="breadcrumb-item active text-white">Services</span>
            </nav>
        </div>
    </div>
</section>

{{-- Services Grid --}}
<section class="section section-dark py-5" style="background-color: #0f0f0f;">
    <div class="container">
        <div class="row g-4">
            @forelse($services as $service)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card h-100 d-flex flex-column rounded-4 overflow-hidden shadow-2xl position-relative" style="background: rgba(22, 22, 22, 0.9); border: 1px solid rgba(201, 169, 110, 0.2); transition: all 0.4s ease;">
                    <div class="position-relative overflow-hidden" style="height: 260px;">
                        <img src="{{ $service->featured_image_url }}" alt="{{ $service->name }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.6s ease;" loading="lazy">
                        @if($service->starting_price)
                        <span class="position-absolute top-0 end-0 m-3 px-3 py-1 rounded-pill font-weight-bold" style="background: rgba(15, 15, 15, 0.85); border: 1px solid #c9a96e; color: #c9a96e; font-size: 0.85rem; backdrop-filter: blur(8px);">
                            From ₹{{ number_format($service->starting_price, 0) }}
                        </span>
                        @endif
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="mb-3 d-flex align-items-center">
                            <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: rgba(201, 169, 110, 0.12); color: #c9a96e; font-size: 1.25rem;">
                                <i class="{{ $service->icon ?? 'fas fa-camera' }}"></i>
                            </div>
                            <h3 class="mb-0 text-white" style="font-family: 'Playfair Display', serif; font-size: 1.4rem;">{{ $service->name }}</h3>
                        </div>
                        <p class="text-gray flex-grow-1" style="font-size: 0.95rem; line-height: 1.6; color: #b0b0b0;">
                            {{ Str::limit($service->short_description ?? 'Luxury wedding photography and cinematic film coverage tailored to your special dates.', 120) }}
                        </p>
                        <div class="pt-3 mt-auto border-top" style="border-color: rgba(201, 169, 110, 0.15) !important;">
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-outline-gold w-100 d-flex align-items-center justify-content-between py-2 rounded-3 text-decoration-none">
                                <span>Explore Details</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 rounded-gold mx-auto shadow-lg" style="background:var(--color-dark-2);border:1px solid var(--color-gold-fade);max-width:600px;">
                    <i class="fas fa-camera-retro text-gold fa-4x mb-3"></i>
                    <h3 class="font-primary text-white mb-2" style="font-size:1.75rem;">No Services Found</h3>
                    <p class="text-gray mb-4">Our studio services are currently being updated. Please check back shortly or contact our team for custom bookings.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-outline-gold"><i class="fas fa-envelope me-2"></i> Contact Us</a>
                        <a href="{{ url('/') }}" class="btn btn-gold"><i class="fas fa-home me-2"></i> Home</a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- Custom Booking CTA --}}
<section class="contact-cta section py-5" style="background: linear-gradient(135deg, rgba(25,22,15,0.95) 0%, rgba(15,15,15,0.98) 100%); border-top: 1px solid rgba(201,169,110,0.2);">
    <div class="container text-center py-4" data-aos="fade-up">
        <span class="section-label text-gold text-uppercase" style="letter-spacing: 2px; font-size: 0.8rem;">CUSTOM COVERAGE</span>
        <h2 class="section-title my-3 text-white" style="font-family: 'Playfair Display', serif; font-size: 2.3rem;">Need a Tailored Photography Experience?</h2>
        <p class="section-subtitle mx-auto mb-4 text-gray" style="max-width: 650px; font-size: 1.05rem; line-height: 1.7;">Every celebration is distinct. Talk to our creative team to build a customized coverage package with drone videography, luxury albums, and multi-day coverage.</p>
        <a href="{{ route('booking.create') }}" class="btn btn-gold px-4 py-3 font-weight-bold" style="border-radius: 30px; font-size: 1rem;">
            <i class="fas fa-calendar-check me-2"></i> Book Customized Session
        </a>
    </div>
</section>

@endsection
