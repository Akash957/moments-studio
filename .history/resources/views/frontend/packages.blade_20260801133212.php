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
    :root {
        --gold-light: #f9e596;
        --gold-main: #d4af37;
        --gold-dark: #997a15;
        --bg-deep: #050505;
        --bg-card: #0f0f11;
        --text-light: #f4f4f5;
        --text-muted: #a1a1aa;
        --card-border: rgba(212, 175, 55, 0.15);
    }

    /* === Luxury Hero Section === */
    .page-hero {
        position: relative;
        padding: 120px 0 80px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    .page-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(5,5,5,0.7), var(--bg-deep));
    }

    .page-hero-content {
        position: relative;
        z-index: 2;
    }

    /* === Typography & Utilities === */
    .font-serif { font-family: 'Cormorant Garamond', 'Playfair Display', serif; }
    .text-gold { color: var(--gold-main); }
    
    .section-dark { background-color: var(--bg-deep); }
    
    .section-subtitle {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold-main);
        margin-bottom: 1rem;
        position: relative;
    }
    
    .section-subtitle::before, .section-subtitle::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 30px;
        height: 1px;
        background: var(--gold-main);
    }
    .section-subtitle::before { right: 100%; margin-right: 15px; }
    .section-subtitle::after { left: 100%; margin-left: 15px; }

    /* === Premium Grid & Cards === */
    .packages-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 2.5rem;
        margin-top: 3rem;
    }

    .package-card-item {
        background: linear-gradient(145deg, var(--bg-card) 0%, #0a0a0c 100%);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 2rem;
        position: relative;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    /* Subtle glow behind card */
    .package-card-item::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 16px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(212,175,55,0.4), transparent, transparent, rgba(212,175,55,0.1));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .package-card-item.popular {
        border-color: rgba(212, 175, 55, 0.6);
        background: linear-gradient(145deg, #131317 0%, #050505 100%);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.8), 0 0 40px rgba(212, 175, 55, 0.1);
        transform: translateY(-10px);
    }

    .package-card-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.9), 0 0 50px rgba(212, 175, 55, 0.15);
    }
    
    .package-card-item:hover::before { opacity: 1; }

    /* === Badges & Ribbons === */
    .package-top-badge {
        position: absolute;
        top: 1.5rem;
        right: -35px;
        background: linear-gradient(90deg, var(--gold-main), var(--gold-light));
        color: #000;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 40px;
        transform: rotate(45deg);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4);
        z-index: 10;
    }

    /* === Card Header & Image === */
    .package-header-banner {
        height: 160px;
        border-radius: 10px;
        overflow: hidden;
        margin: -1rem -1rem 1.5rem -1rem;
        position: relative;
    }

    .package-header-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .package-card-item:hover .package-header-banner img {
        transform: scale(1.1);
    }

    .package-header-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, var(--bg-card) 5%, transparent 100%);
    }

    /* === Tags === */
    .package-tags-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .service-tag {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: var(--gold-light);
        background: rgba(212, 175, 55, 0.1);
        border: 1px solid rgba(212, 175, 55, 0.2);
        padding: 4px 12px;
        border-radius: 4px;
    }

    .feature-tag {
        font-size: 0.65rem;
        color: var(--text-muted);
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 4px 10px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* === Content === */
    .package-title {
        font-size: 2rem;
        font-weight: 600;
        color: var(--text-light);
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }

    .package-tagline {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    /* === Pricing === */
    .price-box {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .original-price {
        text-decoration: line-through;
        color: rgba(255, 255, 255, 0.3);
        font-size: 1.1rem;
    }

    .main-price {
        font-size: 3rem;
        font-weight: 700;
        color: var(--gold-main);
        line-height: 1;
        display: flex;
        align-items: flex-start;
        gap: 2px;
    }

    .main-price .currency {
        font-size: 1.5rem;
        font-family: sans-serif;
        margin-top: 4px;
    }

    .savings-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--gold-light);
        font-size: 0.8rem;
        font-weight: 600;
        background: rgba(212, 175, 55, 0.1);
        padding: 6px 12px;
        border-radius: 30px;
        width: fit-content;
    }

    /* === Features Grid === */
    .features-grid-list {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem 1rem;
        flex-grow: 1;
    }

    .features-grid-list li {
        font-size: 0.85rem;
        color: var(--text-light);
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.4;
    }

    .features-grid-list li.excluded {
        color: rgba(255, 255, 255, 0.25);
    }

    .feature-icon {
        font-size: 0.9rem;
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* === Buttons === */
    .btn-package-action {
        background: linear-gradient(135deg, #d4af37 0%, #aa7c11 100%);
        color: #000;
        font-weight: 700;
        font-size: 0.95rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: none;
        border-radius: 8px;
        padding: 1rem;
        width: 100%;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        margin-top: auto;
    }

    .btn-package-action:hover {
        background: linear-gradient(135deg, #f9e596 0%, #d4af37 100%);
        color: #000;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
    }

    .btn-outline-gold {
        background: transparent;
        border: 1px solid var(--gold-main);
        color: var(--gold-main);
        transition: all 0.3s ease;
    }

    .btn-outline-gold:hover {
        background: var(--gold-main);
        color: #000;
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .features-grid-list { grid-template-columns: 1fr; }
        .page-hero { padding: 100px 0 60px; }
        .main-price { font-size: 2.5rem; }
    }
</style>

{{-- Hero Section --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920');">
    <div class="container text-center page-hero-content">
        <span class="section-subtitle">Investment</span>
        <h1 class="display-4 font-serif text-white fw-bold mb-3">Packages & Pricing</h1>
        <nav class="breadcrumb justify-content-center bg-transparent p-0 m-0 text-white-50">
            <span class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></span>
            <span class="breadcrumb-separator mx-2"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i></span>
            <span class="breadcrumb-item text-gold active">Packages</span>
        </nav>
    </div>
</section>

{{-- Packages Section --}}
<section class="section-dark py-5">
    <div class="container py-4">

        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-subtitle">Transparent Luxury</span>
            <h2 class="display-5 font-serif text-white fw-bold mb-3">Tailored Wedding Collections</h2>
            <p class="lead mx-auto" style="color: var(--text-muted); max-width: 700px; font-size: 1.1rem;">
                Every love story deserves timeless perfection. Choose from our curated photography and cinematography packages tailored to your vision.
            </p>
        </div>

        <div class="packages-wrapper">
            @forelse($packages as $package)
            @php
                $headerImage = $package->image_url ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800';
            @endphp
            
            <div class="package-card-item {{ $package->is_popular ? 'popular' : '' }}" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                
                {{-- Corner Ribbon Badge --}}
                @if($package->badge)
                    <div class="package-top-badge">{{ $package->badge }}</div>
                @elseif($package->is_popular)
                    <div class="package-top-badge">Most Popular</div>
                @elseif($package->discount_percentage > 0)
                    <div class="package-top-badge">Save {{ $package->discount_percentage }}%</div>
                @endif

                {{-- Banner Image --}}
                <div class="package-header-banner">
                    <img src="{{ $headerImage }}" alt="{{ $package->name }}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=800';">
                    <div class="package-header-overlay"></div>
                </div>

                {{-- Badges & Service Info --}}
                <div class="package-tags-wrapper">
                    @if($package->service)
                    <span class="service-tag">
                        <i class="fas fa-camera-retro me-1"></i> {{ $package->service->name }}
                    </span>
                    @endif

                    @if($package->includes_video)
                    <span class="feature-tag"><i class="fas fa-video text-gold"></i> 4K Video</span>
                    @endif
                    @if($package->includes_drone)
                    <span class="feature-tag"><i class="fas fa-drone text-gold"></i> Drone</span>
                    @endif
                    @if($package->includes_album)
                    <span class="feature-tag"><i class="fas fa-book-open text-gold"></i> Album</span>
                    @endif
                </div>

                {{-- Title & Tagline --}}
                <h3 class="package-title font-serif">{{ $package->name }}</h3>
                @if($package->tagline)
                <p class="package-tagline">{{ $package->tagline }}</p>
                @endif

                {{-- Pricing --}}
                <div class="price-box">
                    <div class="d-flex align-items-end flex-wrap gap-2">
                        @if($package->original_price && $package->original_price > $package->price)
                        <span class="original-price">{{ $package->formatted_original_price }}</span>
                        @endif
                        <span class="main-price font-serif">
                            <span class="currency">₹</span>{{ number_format($package->price, 0) }}
                        </span>
                    </div>

                    @if($package->savings_amount > 0)
                    <div class="savings-pill">
                        <i class="fas fa-sparkles"></i> Save ₹{{ number_format($package->savings_amount, 0) }} ({{ $package->discount_percentage }}% OFF)
                    </div>
                    @endif
                </div>

                {{-- Features List --}}
                <ul class="features-grid-list">
                    @foreach($package->features as $feature)
                    <li class="{{ !$feature->is_included ? 'excluded' : '' }}">
                        @if($feature->is_included)
                            <i class="fas fa-check text-gold feature-icon"></i>
                        @else
                            <i class="fas fa-times feature-icon" style="color: rgba(255,255,255,0.2);"></i>
                        @endif
                        <span>{{ $feature->feature }}</span>
                    </li>
                    @endforeach
                </ul>

                {{-- Action Button --}}
                <a href="{{ route('booking.create', ['package_id' => $package->id]) }}" class="btn-package-action">
                    <span>Reserve Date</span> <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            @empty
            {{-- Empty State --}}
            <div class="col-12 text-center py-5" style="grid-column: 1 / -1;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(212,175,55,0.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                    <i class="fas fa-ring fa-2x text-gold"></i>
                </div>
                <h3 class="font-serif text-white mb-2">Custom Collections Available</h3>
                <p class="text-muted max-w-500 mx-auto">Contact us to get a personalized proposal tailored specifically for your wedding dates and vision.</p>
            </div>
            @endforelse
        </div>

        {{-- Custom Quote CTA --}}
        <div class="text-center mt-5 pt-4" data-aos="fade-up">
            <p class="mb-3 text-muted" style="font-size: 0.95rem;">Looking for customized multi-day wedding coverage?</p>
            <button class="btn btn-outline-gold px-5 py-2 rounded-pill fw-bold" @click="quoteOpen = true">
                <i class="fas fa-envelope-open-text me-2"></i> Request Custom Proposal
            </button>
        </div>

    </div>
</section>

@endsection