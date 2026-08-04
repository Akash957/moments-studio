@extends('layouts.app')
@php $seoPage = 'home'; @endphp

@section('content')

{{-- ====================================================
     HERO SECTION — Full Screen Cinematic Slider
     ==================================================== --}}
<section class="hero-section" id="hero">

    {{-- Hero Swiper --}}
    <div class="swiper hero-swiper" id="heroSwiper">
        <div class="swiper-wrapper">
            @foreach($heroSliders as $slide)
            <div class="swiper-slide hero-slide">
                @if($slide->media_type === 'video' && $slide->video_url)
                <video class="hero-slide-img" autoplay muted loop playsinline>
                    <source src="{{ $slide->video_url }}" type="video/mp4">
                </video>
                @else
                <img
                    src="{{ $slide->image_url }}"
                    alt="{{ $slide->title }}"
                    class="hero-slide-img"
                    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                >
                @endif

                {{-- Overlay --}}
                <div class="hero-overlay" style="background:linear-gradient(to right, rgba(10,10,10,{{ $slide->overlay_opacity + 0.2 }}) 0%, rgba(10,10,10,{{ $slide->overlay_opacity }}) 50%, rgba(10,10,10,{{ $slide->overlay_opacity - 0.2 }}) 100%);">
                </div>

                {{-- Content --}}
                <div class="hero-content">
                    <div class="container">
                        <div class="hero-text-wrap">
                            @if($slide->subtitle)
                            <span class="hero-subtitle">{{ $slide->subtitle }}</span>
                            @endif
                            <h1 class="hero-title">{{ $slide->title }}</h1>
                            @if($slide->description)
                            <p class="hero-description">{{ $slide->description }}</p>
                            @endif
                            <div class="hero-actions">
                                @if($slide->button_text && $slide->button_url)
                                <a href="{{ $slide->button_url }}" class="btn btn-primary">
                                    <i class="fas fa-images me-1"></i> {{ $slide->button_text }}
                                </a>
                                @endif
                                @if($slide->button_text_2 && $slide->button_url_2)
                                    @if($slide->button_url_2 === '#quote-popup')
                                    <button class="btn btn-outline" @click="quoteOpen = true">
                                        <span class="btn-play" style="width:40px;height:40px;font-size:0.875rem;">
                                            <i class="fas fa-play"></i>
                                        </span>
                                        {{ $slide->button_text_2 }}
                                    </button>
                                    @else
                                    <a href="{{ $slide->button_url_2 }}" class="btn btn-outline">
                                        {{ $slide->button_text_2 }}
                                    </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Custom Navigation --}}
        <div class="hero-nav">
            <button class="hero-nav-btn" id="heroPrev" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="hero-nav-btn" id="heroNext" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        {{-- Pagination --}}
        <div class="swiper-pagination hero-pagination" style="position:absolute;bottom:5rem;left:5%;text-align:left;width:auto;"></div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="hero-scroll-indicator">
        <div class="scroll-dot"></div>
        <span>Scroll</span>
    </div>

    {{-- Stats Bar --}}
    <div class="hero-stats-bar">
        <div class="container">
            <div class="hero-stats-inner">
                <div class="hero-stat-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="hero-stat-number">
                        <span class="counter" data-target="{{ $stats['experience'] ?? 12 }}">0</span>+
                    </div>
                    <div class="hero-stat-label">Years Experience</div>
                </div>
                <div class="hero-stat-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="hero-stat-number">
                        <span class="counter" data-target="{{ $stats['weddings'] ?? 850 }}">0</span>+
                    </div>
                    <div class="hero-stat-label">Weddings</div>
                </div>
                <div class="hero-stat-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="hero-stat-number">
                        <span class="counter" data-target="{{ $stats['clients'] ?? 1250 }}">0</span>+
                    </div>
                    <div class="hero-stat-label">Happy Clients</div>
                </div>
                <div class="hero-stat-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="hero-stat-number">
                        <span class="counter" data-target="{{ $stats['awards'] ?? 28 }}">0</span>+
                    </div>
                    <div class="hero-stat-label">Awards Won</div>
                </div>
            </div>
        </div>
    </div>

</section>

{{-- ====================================================
     ABOUT SECTION
     ==================================================== --}}
<section class="section about-section section-dark" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="about-image-wrap">
                    <img
                        src="{{ $aboutSettings['home_about_image'] ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800' }}"
                        alt="About Moments Studio"
                        class="about-img-main"
                        loading="lazy"
                    >
                    <div class="about-badge">
                        <span class="years">{{ $stats['experience'] ?? 12 }}</span>
                        <span class="label">Years of<br>Excellence</span>
                    </div>
                    <img
                        src="{{ $aboutSettings['home_about_accent'] ?? 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=400' }}"
                        alt="Our Work"
                        class="about-img-accent"
                        loading="lazy"
                    >
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="section-label">About Us</span>
                <h2 class="section-title mb-3">
                    {!! nl2br(e($aboutSettings['home_about_title'] ?? "We Don't Just Take Photos,\nWe Create Masterpieces")) !!}
                </h2>
                <p class="section-subtitle mb-4">
                    {{ $aboutSettings['home_about_text'] ?? 'At Moments Studio, we believe every moment is unique and deserves to be remembered forever. Our passion is to turn your special moments into timeless stories.' }}
                </p>
                <div class="about-features">
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $aboutSettings['feature_1'] ?? 'Creative & Professional Team' }}</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $aboutSettings['feature_2'] ?? 'High-End Equipment' }}</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $aboutSettings['feature_3'] ?? '100% Client Satisfaction' }}</span>
                    </div>
                    <div class="about-feature-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ $aboutSettings['feature_4'] ?? 'Worldwide Available' }}</span>
                    </div>
                </div>
                <div class="signature">{{ $aboutSettings['home_about_signature'] ?? 'Moments Studio' }}</div>
                <div class="mt-4 d-flex gap-3 flex-wrap">
                    <a href="{{ route('about') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-1"></i> Discover Our Story
                    </a>
                    <button class="btn btn-outline-gold" @click="quoteOpen = true">
                        Get Free Quote
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     SERVICES SECTION
     ==================================================== --}}
<section class="section section-darker" id="services">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Our Services</span>
            <h2 class="section-title mb-3">What We Offer</h2>
            <p class="section-subtitle">From intimate ceremonies to grand weddings, we cover every precious moment with artistry and passion.</p>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="service-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="service-card-icon">
                    <i class="{{ $service->icon ?? 'fas fa-camera' }}"></i>
                </div>
                <div class="service-card-name">{{ $service->name }}</div>
                <p class="service-card-desc">{{ $service->short_description }}</p>
                @if($service->starting_price)
                <div class="service-card-price">Starting ₹{{ number_format($service->starting_price, 0) }}</div>
                @endif
            </a>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('services.index') }}" class="btn btn-outline-gold">
                View All Services <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

{{-- ====================================================
     FEATURED PORTFOLIO (GALLERY SLIDER)
     ==================================================== --}}
<section class="section section-dark py-5" id="portfolio">
    <div class="container">
        <div class="section-header center mb-5" data-aos="fade-up">
            <span class="section-label">Our Gallery</span>
            <h2 class="section-title mb-3">Our Recent Masterpieces</h2>
            <p class="section-subtitle">A curated collection of unforgettable moments, raw emotions, and luxury artistry captured by {{ \App\Models\Setting::get('site_name', 'Moments Studio') }}.</p>
        </div>
        <div class="row g-4">
            @forelse($featuredGallery as $photo)
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 4) * 100 }}">
                <div class="masterpiece-card">
                    <div class="masterpiece-img-wrap">
                        <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title ?? (\App\Models\Setting::get('site_name', 'Moments Studio') . ' Masterpiece') }}" loading="lazy">
                        <div class="masterpiece-overlay">
                            @if($photo->category)
                            <span class="masterpiece-category-badge">{{ $photo->category->name }}</span>
                            @endif
                            <h4 class="masterpiece-title">{{ $photo->title ?? 'Masterpiece Moment' }}</h4>
                            <a href="{{ $photo->image_url }}" target="_blank" class="masterpiece-zoom-btn" title="View High Res Image">
                                <i class="fas fa-expand-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">No gallery photos uploaded yet.</p>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('gallery.index') }}" class="btn btn-gold px-4 py-3 fs-6">
                Explore Full Gallery <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

{{-- ====================================================
     LATEST WEDDINGS (ALBUMS)
     ==================================================== --}}
<section class="section section-darker" id="weddings">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Featured Work</span>
            <h2 class="section-title mb-3">Latest Weddings</h2>
            <p class="section-subtitle">Every love story is unique — here are some of the beautiful moments we have captured recently.</p>
        </div>
        <div class="row g-4">
            @foreach($featuredAlbums as $album)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('albums.show', $album->slug) }}" class="album-card d-block">
                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}" class="album-card-img" loading="lazy">
                    <div class="album-card-overlay">
                        <div class="album-card-category">{{ $album->category?->name ?? 'Wedding' }}</div>
                        <h3 class="album-card-title">{{ $album->title }}</h3>
                        <div class="album-card-info">
                            <i class="fas fa-map-marker-alt me-1" style="color:var(--color-gold);"></i>
                            {{ $album->location }}
                            @if($album->event_date)
                            <span class="ms-3">
                                <i class="fas fa-calendar me-1" style="color:var(--color-gold);"></i>
                                {{ $album->event_date->format('M Y') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="album-card-count">{{ $album->image_count }} Photos</div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('albums.index') }}" class="btn btn-outline-gold">
                View All Albums <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>



{{-- ====================================================
     WHY CHOOSE US / EXPERIENCE COUNTER
     ==================================================== --}}
<section class="section stats-section" id="why-us" style="position:relative;overflow:hidden;">
    <div class="stats-bg" style="background-image:url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920');"></div>
    <div class="stats-overlay"></div>
    <div class="container" style="position:relative;z-index:2;">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Why Choose Us</span>
            <h2 class="section-title mb-5">{{ $stats['experience'] ?? 12 }}+ Years of Capturing<br><em class="text-gold">Timeless Love Stories</em></h2>
        </div>
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="row g-4">
                    @php
                    $reasons = [
                        ['icon' => 'fas fa-camera', 'title' => 'Premium Equipment',    'desc' => 'We use the latest professional cameras and lenses for stunning image quality.'],
                        ['icon' => 'fas fa-heart',   'title' => 'Passionate Team',      'desc' => 'Our photographers are deeply passionate about capturing authentic emotions.'],
                        ['icon' => 'fas fa-shield-alt','title' => '100% Satisfaction', 'desc' => 'We guarantee complete client satisfaction with our premium service.'],
                        ['icon' => 'fas fa-globe',   'title' => 'Worldwide Coverage',   'desc' => 'Available for destination weddings across India and internationally.'],
                    ];
                    @endphp
                    @foreach($reasons as $reason)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div style="background:rgba(255,255,255,0.05);backdrop-filter:blur(10px);border:1px solid rgba(201,169,110,0.15);border-radius:var(--radius-lg);padding:1.5rem;height:100%;">
                            <div style="width:48px;height:48px;background:rgba(201,169,110,0.1);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                                <i class="{{ $reason['icon'] }}" style="color:var(--color-gold);font-size:1.125rem;"></i>
                            </div>
                            <h4 class="font-primary mb-2" style="font-size:1rem;font-weight:600;">{{ $reason['title'] }}</h4>
                            <p style="font-size:0.8125rem;color:rgba(255,255,255,0.65);line-height:1.7;">{{ $reason['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="stats-inner" style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.5rem;">
                    @php
                    $counters = [
                        ['target' => $stats['weddings'] ?? 850,  'label' => 'Weddings Covered',  'suffix' => '+'],
                        ['target' => $stats['clients'] ?? 1250,  'label' => 'Happy Clients',     'suffix' => '+'],
                        ['target' => $stats['awards'] ?? 28,     'label' => 'Awards Won',         'suffix' => '+'],
                        ['target' => $stats['experience'] ?? 12, 'label' => 'Years Experience',   'suffix' => '+'],
                    ];
                    @endphp
                    @foreach($counters as $counter)
                    <div class="stat-item glass" style="border-radius:var(--radius-lg);text-align:center;" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="stat-number">
                            <span class="counter" data-target="{{ $counter['target'] }}">0</span>{{ $counter['suffix'] }}
                        </div>
                        <div class="stat-label">{{ $counter['label'] }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-check me-2"></i> Book Your Date
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     PACKAGES & PRICING SECTION — 10/10 Dedicated Luxury
     ==================================================== --}}
@if($packages->count() > 0)
<section class="section section-dark py-5" id="packages">
    <div class="container py-4">
        
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4" data-aos="fade-up">
            <div>
                <span class="section-label text-gold font-weight-bold text-uppercase tracking-widest" style="letter-spacing:3px;">PACKAGES</span>
                <h2 class="section-title text-white font-family-serif display-5 mb-2">Choose Your Perfect Package</h2>
                <p class="section-subtitle text-light lead fs-6 max-w-700 m-0" style="opacity: 0.85;">
                    Transparent pricing with no hidden fees. Pick the package that fits your dream wedding.
                </p>
            </div>
            
            {{-- Carousel Navigation Controls --}}
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-outline-gold rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;" @click="scrollCarousel('homePkgScrollTrack', -360)" title="Previous Package">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-outline-gold rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;" @click="scrollCarousel('homePkgScrollTrack', 360)" title="Next Package">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        {{-- Horizontal Scroll Track --}}
        <div id="homePkgScrollTrack" class="d-flex gap-4 overflow-x-auto pb-5 pt-2 px-2" style="scroll-behavior:smooth; scroll-snap-type:x mandatory; scrollbar-width:thin; scrollbar-color: #c9a96e rgba(255,255,255,0.05); align-items:stretch;">
            @foreach($packages as $package)
            @php
                $headerImage = $package->image_url ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800';
                $featuresList = $package->features->pluck('feature')->toArray();
                $pkgJson = json_encode([
                    'id' => $package->id,
                    'name' => $package->name,
                    'tagline' => $package->tagline,
                    'price' => '₹' . number_format($package->price, 0),
                    'original_price' => $package->formatted_original_price,
                    'savings' => $package->savings_amount > 0 ? '🔥 Save ₹' . number_format($package->savings_amount, 0) . ' (' . $package->discount_percentage . '% OFF)' : null,
                    'badge' => $package->badge ?: ($package->is_popular ? 'MOST POPULAR' : null),
                    'features' => $featuresList
                ]);
            @endphp
            
            <div class="package-card {{ $package->is_popular ? 'popular' : '' }}" style="flex:0 0 340px; min-width:320px; max-width:350px; scroll-snap-align:start; display:flex; flex-direction:column; padding:1.75rem 1.5rem;" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                
                @if($package->badge)
                    <div class="package-badge">{{ $package->badge }}</div>
                @elseif($package->is_popular)
                    <div class="package-badge" style="background:linear-gradient(135deg, #e8c98a, #a07840); color:#000;">MOST POPULAR</div>
                @elseif($package->discount_percentage > 0)
                    <div class="package-badge" style="background:#d9534f;color:#fff;">SAVE {{ $package->discount_percentage }}%</div>
                @endif

                {{-- Photo Banner --}}
                <a href="{{ route('packages.show', $package->slug) }}" class="package-card-image mb-3 d-block text-decoration-none" style="margin:-1.75rem -1.5rem 1.25rem -1.5rem; overflow:hidden; border-radius:16px 16px 0 0; height:150px; position:relative;">
                    <img src="{{ $headerImage }}" alt="{{ $package->name }}" class="w-100 h-100" style="object-fit:cover; transition:transform 0.5s ease;" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800';">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(15,15,18,0.95), transparent 70%);"></div>
                </a>

                {{-- Highlights Badges --}}
                <div class="d-flex flex-wrap gap-1 mb-2">
                    @if($package->includes_video)
                    <span class="badge bg-dark border border-gold text-gold" style="font-size:0.68rem; padding:4px 8px;"><i class="fas fa-video me-1"></i> 4K Video</span>
                    @endif
                    @if($package->includes_drone)
                    <span class="badge bg-dark border border-gold text-gold" style="font-size:0.68rem; padding:4px 8px;"><i class="fas fa-paper-plane me-1"></i> Drone</span>
                    @endif
                    @if($package->includes_album)
                    <span class="badge bg-dark border border-gold text-gold" style="font-size:0.68rem; padding:4px 8px;"><i class="fas fa-book-open me-1"></i> Album</span>
                    @endif
                </div>

                <a href="{{ route('packages.show', $package->slug) }}" class="text-decoration-none">
                    <h3 class="package-name text-gold font-family-serif h4 mb-1">{{ $package->name }}</h3>
                </a>
                <p class="small text-light opacity-75 mb-3 text-truncate">{{ $package->tagline ?? 'Complete Premium Coverage' }}</p>

                <div class="package-price mb-3">
                    @if($package->original_price && $package->original_price > $package->price)
                    <span class="text-decoration-line-through text-muted small me-2" style="font-size:0.95rem;">
                        {{ $package->formatted_original_price }}
                    </span>
                    @endif
                    <span class="fs-2 text-gold font-family-serif font-weight-bold">
                        ₹{{ number_format($package->price, 0) }}
                    </span>
                    @if($package->savings_amount > 0)
                    <div class="badge bg-outline-gold text-gold p-1 mt-1 w-100" style="font-size:0.75rem;">
                        Save ₹{{ number_format($package->savings_amount, 0) }} ({{ $package->discount_percentage }}% OFF)
                    </div>
                    @endif
                </div>

                {{-- Top Highlights --}}
                <ul class="list-unstyled mb-3" style="font-size:0.825rem; color:rgba(255,255,255,0.85);">
                    @foreach($package->features->take(3) as $feature)
                    <li class="py-1 text-truncate">
                        <i class="fas fa-check-circle text-gold me-1"></i> {{ $feature->feature }}
                    </li>
                    @endforeach
                </ul>

                {{-- Actions --}}
                <div class="mt-auto d-flex flex-column gap-2 pt-2">
                    <a href="{{ route('packages.show', $package->slug) }}" class="btn btn-gold btn-sm w-100 font-weight-bold text-center" style="padding:0.65rem;">
                        <i class="fas fa-eye me-1"></i> View Full Package Details
                    </a>
                    <button type="button" class="btn btn-outline-gold btn-sm w-100" @click="openPackageModal({{ $pkgJson }})" style="padding:0.5rem;">
                        <i class="fas fa-layer-group me-1"></i> Quick View Modal
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        <div class="text-center mt-4" data-aos="fade-up">
            <p class="text-muted mb-3">Looking for custom multiday wedding coverage or specific event package?</p>
            <a href="{{ route('booking.create') }}" class="btn btn-gold px-4 py-3">
                <i class="fas fa-paper-plane me-2"></i> Request Custom Package Proposal
            </a>
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     AWARDS SECTION
     ==================================================== --}}
@if($awards->count() > 0)
<section class="section section-darker" id="awards">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Recognition</span>
            <h2 class="section-title mb-3">Award-Winning Photography</h2>
            <p class="section-subtitle">Recognized by leading photography organizations for our commitment to excellence.</p>
        </div>
        <div class="awards-grid">
            @foreach($awards as $award)
            <div class="award-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="award-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div>
                    <div class="award-title">{{ $award->title }}</div>
                    <div class="award-org">{{ $award->organization }}</div>
                    <div class="award-year">{{ $award->year }}</div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('awards.index') }}" class="btn btn-outline-gold">
                View All Awards <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     TESTIMONIALS SECTION
     ==================================================== --}}
@if($testimonials->count() > 0)
<section class="section section-dark py-5" id="testimonials">
    <div class="container py-4">
        <div class="section-header center text-center mb-5" data-aos="fade-up">
            <span class="section-label text-gold font-weight-bold text-uppercase tracking-widest">Testimonials</span>
            <h2 class="section-title text-gold font-family-serif display-5 mb-3">What Our Clients Say</h2>
            <p class="section-subtitle text-light lead fs-6 max-w-700 mx-auto" style="opacity: 0.85;">
                Real words from real couples who trusted us with their most precious memories.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($testimonials as $t)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="testimonial-card-luxury h-100">
                    <div class="testimonial-quote-icon">“</div>
                    <div class="testimonial-stars mb-3">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star text-gold {{ $i <= $t->rating ? '' : 'text-secondary' }}" style="{{ $i > $t->rating ? 'opacity:0.25' : '' }}"></i>
                        @endfor
                    </div>
                    <p class="testimonial-review-text mb-4">
                        "{{ $t->review }}"
                    </p>
                    <div class="d-flex align-items-center mt-auto pt-3 border-top border-secondary">
                        @if($t->client_image)
                        <img src="{{ asset('storage/' . $t->client_image) }}" alt="{{ $t->client_name }}" class="rounded-circle me-3 border border-warning" style="width: 52px; height: 52px; object-fit: cover;">
                        @else
                        @php
                            $words = explode(' ', trim($t->client_name));
                            $initials = count($words) >= 2 
                                ? strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1))
                                : strtoupper(substr($t->client_name, 0, 2));
                        @endphp
                        <div class="testimonial-avatar-ring me-3 flex-shrink-0">
                            {{ $initials }}
                        </div>
                        @endif
                        <div>
                            <h4 class="h6 font-family-serif text-white mb-1 font-weight-bold">{{ $t->client_name }}</h4>
                            @if($t->wedding_location)
                            <span class="text-gold small d-block">
                                <i class="fas fa-map-marker-alt me-1"></i> {{ $t->wedding_location }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('testimonials.index') }}" class="btn btn-gold px-4 py-3 fs-6">
                Read All Reviews <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     INSTAGRAM FEED
     ==================================================== --}}
<section class="section section-darker py-5" id="instagram">
    <div class="container">
        <div class="section-header center mb-4" data-aos="fade-up">
            <span class="section-label">{{ \App\Models\Setting::get('instagram_section_label', 'Instagram') }}</span>
            <h2 class="section-title mb-2">{{ \App\Models\Setting::get('instagram_section_title', 'Follow Our Journey') }}</h2>
            <p class="section-subtitle" style="margin-bottom:0;">
                <a href="{{ \App\Models\Setting::get('social_instagram', 'https://instagram.com') }}" target="_blank" class="text-gold font-weight-bold fs-5 text-decoration-none">
                    <i class="fab fa-instagram me-1"></i> {{ \App\Models\Setting::get('site_instagram', '@lovestudios.in') }}
                </a>
            </p>
        </div>

        <div class="row g-3 g-md-4 justify-content-center mt-3">
            @forelse($instagramFeeds as $item)
            <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="{{ ($loop->index % 4) * 80 }}">
                <a href="{{ $item->permalink ?? \App\Models\Setting::get('social_instagram', '#') }}" class="insta-luxury-card d-block" target="_blank" title="View on Instagram">
                    <div class="insta-img-wrapper">
                        <img src="{{ $item->media_url }}" alt="{{ $item->caption ?? 'Instagram Post' }}" loading="lazy">
                        <div class="insta-overlay d-flex flex-column align-items-center justify-content-center">
                            <i class="fab fa-instagram fa-2x text-white mb-2"></i>
                            <span class="badge bg-gold text-dark font-weight-bold px-3 py-2 rounded-pill shadow">View Post <i class="fas fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-4 rounded-4" style="background: #181818; border: 1px dashed rgba(201, 169, 110, 0.3);">
                    <i class="fab fa-instagram fa-3x text-gold mb-3"></i>
                    <h4 class="h5 text-white font-family-serif">Follow Us On Instagram</h4>
                    <p class="text-muted small">Add Instagram posts from the Admin Panel to display them live on the website.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ====================================================
     LATEST BLOG
     ==================================================== --}}
@if($latestBlogs->count() > 0)
<section class="section section-dark" id="blog">
    <div class="container">
        <div class="section-header center" data-aos="fade-up">
            <span class="section-label">Latest Stories</span>
            <h2 class="section-title mb-3">Our Latest Stories</h2>
            <p class="section-subtitle">Tips, inspiration and behind-the-scenes stories from our photography world.</p>
        </div>
        <div class="row g-4">
            @foreach($latestBlogs as $blog)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card d-block h-100">
                    <div class="blog-card-img-wrap">
                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="blog-card-img" loading="lazy">
                        @if($blog->category)
                        <span class="blog-card-category">{{ $blog->category->name }}</span>
                        @endif
                    </div>
                    <div class="blog-card-body">
                        <div class="blog-card-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ $blog->published_at->format('M d, Y') }}</span>
                            <span><i class="fas fa-clock"></i> {{ $blog->reading_time }} min read</span>
                        </div>
                        <h3 class="blog-card-title">{{ $blog->title }}</h3>
                        <p class="blog-card-excerpt">{{ $blog->excerpt_limited }}</p>
                        <span class="btn-arrow">
                            Read More
                            <span class="arrow-circle"><i class="fas fa-arrow-right"></i></span>
                        </span>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('blog.index') }}" class="btn btn-outline-gold">
                View All Stories <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ====================================================
     CONTACT CTA
     ==================================================== --}}
<section class="contact-cta section section-sm">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8" data-aos="fade-right">
                <span class="section-label">Book Now</span>
                <h2 class="section-title mb-3" style="font-size:clamp(1.75rem,3vw,2.75rem);">
                    Ready to Create<br><em class="text-gold">Timeless Memories?</em>
                </h2>
                <p class="section-subtitle">Let's discuss your special day. Reach out to us today and let's make magic together.</p>
            </div>
            <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                <div class="d-flex gap-3 justify-content-lg-end flex-wrap">
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-check me-2"></i> Book Now
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline">
                        <i class="fas fa-envelope me-2"></i> Contact Us
                    </a>
                </div>
                <div class="mt-3" style="text-align:right;">
                    <a href="tel:{{ \App\Models\Setting::get('site_phone', '+919876543210') }}" style="color:var(--color-gold);font-family:var(--font-primary);font-size:1.25rem;">
                        {{ \App\Models\Setting::get('site_phone', '+91 98765 43210') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ====================================================
     GOOGLE MAP — Compact Dark Luxury
     ==================================================== --}}
<div style="position:relative;height:250px;overflow:hidden;border-top:2px solid rgba(201,169,110,0.25);">
    <iframe
        src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAPS_API_KEY', 'AIzaSyBc19C3Weqk97CdYInTUlLlbwBN_MqjLI8') }}&q={{ urlencode(\App\Models\Setting::get('site_address', 'Jaipur, Rajasthan, India')) }}&zoom=14&maptype=roadmap"
        width="100%"
        height="250"
        style="border:0;filter:grayscale(100%) invert(92%) contrast(0.85) brightness(0.65);display:block;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="{{ \App\Models\Setting::get('site_name', 'Moments Studio') }} Location"
    ></iframe>
    {{-- Gradient overlay bottom --}}
    <div style="position:absolute;bottom:0;left:0;right:0;height:60px;background:linear-gradient(transparent,rgba(10,10,10,0.9));z-index:3;pointer-events:none;"></div>
    {{-- Gold pin center --}}
    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-110%);z-index:4;pointer-events:none;">
        <div style="width:36px;height:36px;background:var(--color-gold);border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 15px rgba(201,169,110,0.6);border:2px solid #fff;">
            <i class="fas fa-camera" style="color:#fff;font-size:0.8rem;"></i>
        </div>
        <div style="width:0;height:0;border-left:6px solid transparent;border-right:6px solid transparent;border-top:8px solid var(--color-gold);margin:0 auto;"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ---- Hero Swiper ----
    const heroSwiper = new Swiper('#heroSwiper', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        speed: 1200,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        pagination: {
            el: '.hero-pagination',
            clickable: true,
        },
        navigation: {
            prevEl: '#heroPrev',
            nextEl: '#heroNext',
        },
    });

    // ---- Portfolio Swiper ----
    const portfolioSwiper = new Swiper('#portfolioSwiper', {
        loop: true,
        autoplay: { delay: 3000, disableOnInteraction: false },
        speed: 800,
        slidesPerView: 'auto',
        spaceBetween: 16,
        centeredSlides: true,
        breakpoints: {
            0:   { slidesPerView: 1.5, spaceBetween: 12 },
            576: { slidesPerView: 2.5, spaceBetween: 14 },
            992: { slidesPerView: 4,   spaceBetween: 16 },
        },
    });

    // ---- Portfolio LightGallery ----
    const portfolioGallery = document.querySelector('#portfolioSwiper');
    if (portfolioGallery) {
        lightGallery(portfolioGallery, {
            selector: '.gallery-item',
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
        });
    }

    // ---- Testimonials Swiper ----
    const testimonialsSwiper = new Swiper('#testimonialsSwiper', {
        loop: true,
        autoplay: { delay: 5000, disableOnInteraction: false },
        speed: 800,
        pagination: { el: '.testimonials-pagination', clickable: true },
        breakpoints: {
            0:   { slidesPerView: 1,   spaceBetween: 20 },
            768: { slidesPerView: 2,   spaceBetween: 24 },
            1200:{ slidesPerView: 3,   spaceBetween: 28 },
        },
    });

    // ---- AOS Init ----
    AOS.init({
        duration: 800,
        easing: 'ease-out-cubic',
        once: true,
        offset: 60,
    });

    // ---- Animated Counters ----
    function animateCounters() {
        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const start = Date.now();
            const interval = setInterval(() => {
                const elapsed = Date.now() - start;
                const progress = Math.min(elapsed / duration, 1);
                const value = Math.floor(progress * target);
                counter.textContent = value.toLocaleString();
                if (progress === 1) {
                    clearInterval(interval);
                    counter.textContent = target.toLocaleString();
                }
            }, 16);
        });
    }

    // ---- GSAP Animations ----
    gsap.registerPlugin(ScrollTrigger);

    // Parallax on hero
    gsap.to('.hero-slide-img', {
        yPercent: 30,
        ease: 'none',
        scrollTrigger: {
            trigger: '.hero-section',
            start: 'top top',
            end: 'bottom top',
            scrub: true,
        }
    });

    // Image reveal animation
    gsap.utils.toArray('[data-aos]').forEach(el => {
        ScrollTrigger.create({
            trigger: el,
            start: 'top 85%',
            onEnter: () => {
                if (!counterAnimated) {
                    animateCounters();
                    counterAnimated = true;
                }
            }
        });
    });

    let counterAnimated = false;
    ScrollTrigger.create({
        trigger: '.stats-section',
        start: 'top 80%',
        onEnter: () => {
            if (!counterAnimated) {
                animateCounters();
                counterAnimated = true;
            }
        }
    });

    // Also animate on hero visible immediately
    setTimeout(animateCounters, 1500);
});
</script>
@endpush
