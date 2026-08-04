@extends('layouts.app')
@php
    $seoPage = 'about';
    $seoTitle = 'About Us — ' . \App\Models\Setting::get('site_name', 'Moments Studio') . ' | Luxury Wedding Photography';
    $seoDescription = 'Learn about our passion for luxury wedding photography, our award-winning team, and our 12+ years of preserving timeless memories across the globe.';
@endphp

@section('content')

{{-- Page Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Our Story</span>
            <h1 class="page-hero-title">About {{ \App\Models\Setting::get('site_name', 'Moments Studio') }}</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">About Us</span>
            </nav>
        </div>
    </div>
</section>

{{-- Vision & Story Section --}}
<section class="section section-dark">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800" alt="Moments Studio Photographers" class="img-fluid rounded-gold shadow-lg" loading="lazy">
                    <div style="position:absolute;bottom:-2rem;left:-2rem;background:var(--color-dark-2);border:1px solid var(--color-gold);padding:1.5rem 2rem;border-radius:var(--radius-lg);" class="d-none d-md-block">
                        <div style="font-family:var(--font-primary);font-size:2rem;font-weight:700;color:var(--color-gold);line-height:1;">850+</div>
                        <div style="font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--color-white);margin-top:0.25rem;">Weddings Covered</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-label">Artistry & Passion</span>
                <h2 class="section-title mb-4">Capturing Emotion & Essence Since 2012</h2>
                <p style="color:rgba(255,255,255,0.8);line-height:1.8;" class="mb-3">
                    Founded in 2012 by lead photographer Arjun Sharma, <strong>Moments Studio</strong> was born out of a relentless desire to elevate wedding photography into fine art. We believe every couple’s journey is an intricate tapestry of laughter, quiet intimate glances, and joyful celebrations.
                </p>
                <p style="color:var(--color-gray);line-height:1.8;" class="mb-4">
                    Our signature style blends high-fashion editorial portraits with unobtrusive, raw candid storytelling. Whether it's an intimate destination wedding on the beaches of Goa or a grand royal celebration in Rajasthan, we preserve every second with precision, warmth, and cinematic perfection.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-md);border:1px solid rgba(201,169,110,0.1);">
                            <i class="fas fa-camera text-gold" style="font-size:1.5rem;"></i>
                            <div>
                                <h4 style="font-size:0.9375rem;margin:0;color:var(--color-white);">Editorial Style</h4>
                                <span style="font-size:0.75rem;color:var(--color-gray);">Magazine Quality</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-3 p-3" style="background:var(--color-dark-2);border-radius:var(--radius-md);border:1px solid rgba(201,169,110,0.1);">
                            <i class="fas fa-video text-gold" style="font-size:1.5rem;"></i>
                            <div>
                                <h4 style="font-size:0.9375rem;margin:0;color:var(--color-white);">4K Cinema</h4>
                                <span style="font-size:0.75rem;color:var(--color-gray);">Drone & Film</span>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('contact') }}" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i> Work With Us
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Team Section --}}
<section class="section section-darker">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">The Artists</span>
            <h2 class="section-title mb-3">Meet Our Creative Team</h2>
            <p class="section-subtitle">Dedicated visual storytellers passionate about preserving your most precious memories.</p>
        </div>
        <div class="row g-4">
            @foreach($team as $member)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="team-card">
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="team-card-img" loading="lazy">
                    <div class="team-card-overlay">
                        <h3 class="team-card-name">{{ $member->name }}</h3>
                        <div class="team-card-role">{{ $member->designation }}</div>
                        <p style="font-size:0.75rem;color:var(--color-gray);" class="mb-3">{{ Str::limit($member->bio, 80) }}</p>
                        <div class="team-card-social">
                            @if($member->instagram)
                            <a href="https://instagram.com/{{ ltrim($member->instagram, '@') }}" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            @endif
                            <a href="mailto:{{ Setting::get('site_email', 'info@momentsstudio.in') }}" aria-label="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Awards Banner --}}
@if($awards->count() > 0)
<section class="section section-dark">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Honors & Accolades</span>
            <h2 class="section-title mb-3">Award-Winning Craftsmanship</h2>
        </div>
        <div class="awards-grid">
            @foreach($awards as $award)
            <div class="award-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="award-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div>
                    <div class="award-title">{{ $award->title }}</div>
                    <div class="award-org">{{ $award->organization }}</div>
                    <div class="award-year">{{ $award->year }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
