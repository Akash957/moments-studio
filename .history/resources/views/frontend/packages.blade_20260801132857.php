@extends('layouts.app')
@php
    $brandName = \App\Models\Setting::get('site_name');
    if (!$brandName || str_contains(strtolower($brandName), 'love')) {
        $brandName = 'Moments Studio';
    }
    $seoTitle = 'Photography Packages & Pricing — ' . $brandName;
    $seoDescription = 'Explore luxury wedding photography and videography packages crafted by ' . $brandName . '. Transparent pricing with custom options.';
@endphp

@section('content')

<style>
    /* Compact Luxury Packages Styles */
    .packages-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        margin-top: 1rem;
    }

    .package-card-item {
        flex: 1 1 580px;
        max-width: 680px;
        background: linear-gradient(160deg, #141418 0%, #09090b 100%);
        border: 1px solid rgba(201, 169, 110, 0.35);
        border-radius: 20px;
        padding: 1.75rem 1.75rem;
        position: relative;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        display: flex;
        flex-direction: column;
    }

    .package-card-item.popular {
        border: 2px solid var(--color-gold);
        background: linear-gradient(160deg, #1a1a22 0%, #0d0d12 100%);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7), 0 0 35px rgba(201, 169, 110, 0.18);
    }

    .package-card-item:hover {
        transform: translateY(-5px);
        border-color: var(--color-gold);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 45px rgba(201, 169, 110, 0.25);
    }

    .package-top-badge {
        position: absolute;
        top: -13px;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, #e8c98a, #a07840);
        color: #070708;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 5px 18px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(201, 169, 110, 0.4);
        white-space: nowrap;
        z-index: 2;
    }

    .package-header-banner {
        height: 130px;
        border-radius: 12px;
        overflow: hidden;
        margin: -0.75rem -0.75rem 1.25rem -0.75rem;
        position: relative;
        border: 1px solid rgba(201, 169, 110, 0.15);
    }

    .package-header-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .package-card-item:hover .package-header-banner img {
        transform: scale(1.05);
    }

    .package-header-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(9, 9, 11, 0.95) 0%, rgba(9, 9, 11, 0.25) 100%);
    }

    .package-service-tag {
        display: inline-block;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--color-gold);
        background: rgba(201, 169, 110, 0.1);
        border: 1px solid rgba(201, 169, 110, 0.25);
        padding: 3px 10px;
        border-radius: 30px;
        margin-bottom: 0.5rem;
    }

    .package-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 1px;
        line-height: 1.2;
        margin-bottom: 0.25rem;
    }

    .package-tagline {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.4;
        margin-bottom: 1rem;
    }

    .price-box {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem 1.5rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .original-price {
        text-decoration: line-through;
        color: rgba(255, 255, 255, 0.4);
        font-size: 1.05rem;
    }

    .main-price {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.6rem;
        font-weight: 700;
        color: var(--color-gold);
        line-height: 1;
    }

    .savings-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(201, 169, 110, 0.12);
        border: 1px solid rgba(201, 169, 110, 0.4);
        color: #e8c98a;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 8px;
    }

    /* 2-Column Features Grid for Compact Height */
    .features-grid-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 0.35rem 1.25rem;
        flex-grow: 1;
    }

    .features-grid-list li {
        font-size: 0.84rem;
        color: rgba(255, 255, 255, 0.9);
        padding: 0.3rem 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.05);
    }

    .features-grid-list li.excluded {
        color: rgba(255, 255, 255, 0.35);
        text-decoration: line-through;
    }

    .btn-package-action {
        background: linear-gradient(135deg, #d4b478, #a07840);
        color: #070708;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border: none;
        border-radius: 12px;
        padding: 0.85rem;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.35s ease;
        box-shadow: 0 8px 25px rgba(201, 169, 110, 0.3);
    }

    .btn-package-action:hover {
        background: linear-gradient(135deg, #e8c98a, #c9a96e);
        color: #000000;
        box-shadow: 0 12px 32px rgba(201, 169, 110, 0.45);
        transform: translateY(-2px);
    }
</style>

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Investment</span>
            <h1 class="page-hero-title">Packages & Pricing</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Packages</span>
            </nav>
        </div>
    </div>
</section>

{{-- Packages Section --}}
<section class="section section-dark py-5" style="background-color: #070708;">
    <div class="container">

        <div class="section-header text-center mb-4" data-aos="fade-up">
            <span class="section-label text-gold font-weight-bold" style="letter-spacing:3px;">TRANSPARENT LUXURY INVESTMENT</span>
            <h2 class="display-5 font-family-serif text-white font-weight-bold mb-2">Tailored Wedding Collections</h2>
            <p class="lead text-light max-w-700 mx-auto" style="opacity:0.8; font-size:1rem;">
                Every love story deserves timeless perfection. Choose from our curated photography and cinematography packages.
            </p>
        </div>

        <div class="packages-wrapper">
            @forelse($packages as $package)
            @php
                $headerImage = $package->image_url ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800';
            @endphp
            <div class="package-card-item {{ $package->is_popular ? 'popular' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                
                @if($package->badge)
                    <div class="package-top-badge">{{ $package->badge }}</div>
                @elseif($package->is_popular)
                    <div class="package-top-badge"><i class="fas fa-star me-1"></i> MOST POPULAR</div>
                @elseif($package->discount_percentage > 0)
                    <div class="package-top-badge">SAVE {{ $package->discount_percentage }}% OFF</div>
                @endif

                {{-- Compact Image Banner --}}
                <div class="package-header-banner">
                    <img src="{{ $headerImage }}" alt="{{ $package->name }}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800';">
                    <div class="package-header-overlay"></div>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    @if($package->service)
                    <span class="package-service-tag">
                        <i class="fas fa-camera me-1"></i>{{ $package->service->name }}
                    </span>
                    @endif

                    @if($package->includes_video || $package->includes_drone || $package->includes_album)
                    <div class="d-flex flex-wrap gap-1">
                        @if($package->includes_video)
                        <span class="badge bg-dark border border-gold text-gold" style="font-size:0.7rem; padding:4px 8px;"><i class="fas fa-video me-1"></i> 4K Video</span>
                        @endif
                        @if($package->includes_drone)
                        <span class="badge bg-dark border border-gold text-gold" style="font-size:0.7rem; padding:4px 8px;"><i class="fas fa-paper-plane me-1"></i> Drone</span>
                        @endif
                        @if($package->includes_album)
                        <span class="badge bg-dark border border-gold text-gold" style="font-size:0.7rem; padding:4px 8px;"><i class="fas fa-book-open me-1"></i> Album</span>
                        @endif
                    </div>
                    @endif
                </div>

                <h3 class="package-title">{{ $package->name }}</h3>
                @if($package->tagline)
                <p class="package-tagline">{{ $package->tagline }}</p>
                @endif

                <div class="price-box">
                    <div class="d-flex align-items-baseline gap-2">
                        @if($package->original_price && $package->original_price > $package->price)
                        <span class="original-price">
                            {{ $package->formatted_original_price }}
                        </span>
                        @endif
                        <span class="main-price">
                            <span style="font-size:1.6rem; vertical-align:super; font-family:sans-serif;">₹</span>{{ number_format($package->price, 0) }}
                        </span>
                    </div>

                    @if($package->savings_amount > 0)
                    <div class="savings-pill">
                        <i class="fas fa-fire-alt text-warning"></i> Save ₹{{ number_format($package->savings_amount, 0) }} ({{ $package->discount_percentage }}% OFF)
                    </div>
                    @endif
                </div>

                {{-- 2-Column Features Grid --}}
                <ul class="features-grid-list">
                    @foreach($package->features as $feature)
                    <li class="{{ !$feature->is_included ? 'excluded' : '' }}">
                        @if($feature->is_included)
                            <i class="fas fa-check-circle text-gold me-1" style="font-size:0.85rem;"></i>
                        @else
                            <i class="fas fa-times-circle text-muted me-1" style="font-size:0.85rem;"></i>
                        @endif
                        {{ $feature->feature }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('booking.create', ['package_id' => $package->id]) }}" class="btn-package-action">
                    <i class="fas fa-calendar-check me-1"></i> Book This Package
                </a>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-gold mb-3"></i>
                <h3 class="text-white">Custom Collections Available</h3>
                <p class="text-muted">Contact us to get a personalized proposal tailored for your wedding dates.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-4" data-aos="fade-up">
            <p style="color:rgba(255,255,255,0.7); font-size:0.95rem;" class="mb-2">Looking for customized multi-day wedding coverage?</p>
            <button class="btn btn-outline-gold px-4 py-2" @click="quoteOpen = true" style="border-radius:30px; font-weight:600; font-size:0.9rem;">
                <i class="fas fa-paper-plane me-2"></i> Request Custom Proposal
            </button>
        </div>

    </div>
</section>

@endsection
