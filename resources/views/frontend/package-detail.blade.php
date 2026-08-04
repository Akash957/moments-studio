@extends('layouts.app')
@php
    $brandName = \App\Models\Setting::get('site_name');
    if (!$brandName || str_contains(strtolower($brandName), 'love')) {
        $brandName = 'Moments Studio';
    }
    $seoTitle = $package->name . ' — ' . $brandName;
    $seoDescription = $package->tagline ?: 'Detailed deliverables and pricing for ' . $package->name . ' by ' . $brandName;
    $headerImage = $package->image_url ?: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1200';
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
    }

    .pkg-detail-hero {
        position: relative;
        padding: 120px 0 70px;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    }
    
    .pkg-detail-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(5,5,5,0.75), var(--bg-deep));
    }

    .pkg-hero-content {
        position: relative;
        z-index: 2;
    }

    .font-serif { font-family: 'Cormorant Garamond', 'Playfair Display', serif; }
    .text-gold { color: var(--gold-main); }

    .pkg-main-card {
        background: linear-gradient(160deg, #111116 0%, #09090b 100%);
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 20px;
        padding: 2.25rem;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        margin-bottom: 2rem;
    }

    .pkg-sidebar-card {
        background: linear-gradient(160deg, #16161f 0%, #0d0d12 100%);
        border: 2px solid var(--gold-main);
        border-radius: 20px;
        padding: 2rem;
        position: sticky;
        top: 100px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.8), 0 0 35px rgba(212, 175, 55, 0.15);
    }

    .pkg-image-frame {
        height: 380px;
        border-radius: 16px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(212, 175, 55, 0.2);
        margin-bottom: 2rem;
    }

    .pkg-image-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .feature-check-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 0.9rem 1.1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        transition: all 0.3s ease;
    }

    .feature-check-item:hover {
        border-color: var(--gold-main);
        background: rgba(212, 175, 55, 0.05);
    }

    .btn-book-gold {
        background: linear-gradient(135deg, #d4af37 0%, #aa7c11 100%);
        color: #000;
        font-weight: 800;
        font-size: 1.05rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        border: none;
        border-radius: 12px;
        padding: 1.1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 25px rgba(212, 175, 55, 0.3);
        text-decoration: none;
    }

    .btn-book-gold:hover {
        background: linear-gradient(135deg, #f9e596 0%, #d4af37 100%);
        color: #000;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(212, 175, 55, 0.45);
    }

    .badge-pill-gold {
        background: rgba(212, 175, 55, 0.12);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--gold-light);
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
</style>

{{-- Hero --}}
<section class="pkg-detail-hero" style="background-image: url('{{ $headerImage }}');">
    <div class="container text-center pkg-hero-content">
        @if($package->service)
        <span class="badge-pill-gold text-uppercase mb-3 d-inline-block">
            <i class="fas fa-camera me-1"></i> {{ $package->service->name }}
        </span>
        @endif
        <h1 class="display-3 font-serif text-white fw-bold mb-2">{{ $package->name }}</h1>
        <p class="lead text-light opacity-75 max-w-700 mx-auto mb-4" style="font-size:1.15rem;">
            {{ $package->tagline ?? 'Tailored luxury wedding photography & cinematic film collection.' }}
        </p>

        <nav class="breadcrumb justify-content-center bg-transparent p-0 m-0 text-white-50">
            <span class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></span>
            <span class="breadcrumb-separator mx-2"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i></span>
            <span class="breadcrumb-item"><a href="{{ route('packages.index') }}" class="text-white-50 text-decoration-none">Packages</a></span>
            <span class="breadcrumb-separator mx-2"><i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i></span>
            <span class="breadcrumb-item text-gold active">{{ $package->name }}</span>
        </nav>
    </div>
</section>

{{-- Main Details Content --}}
<section class="py-5" style="background-color: var(--bg-deep);">
    <div class="container py-3">
        <div class="row g-4">
            
            {{-- Left Column: Full Details --}}
            <div class="col-lg-8">
                
                {{-- Cover Image --}}
                <div class="pkg-image-frame">
                    <img src="{{ $headerImage }}" alt="{{ $package->name }}" onerror="this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=1200';">
                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(5,5,5,0.85) 0%, transparent 60%);"></div>
                    <div style="position:absolute; bottom:1.5rem; left:1.5rem; right:1.5rem;" class="d-flex flex-wrap gap-2">
                        @if($package->includes_video)
                        <span class="badge bg-dark border border-gold text-gold p-2"><i class="fas fa-video me-1"></i> 4K Cinematic Video</span>
                        @endif
                        @if($package->includes_drone)
                        <span class="badge bg-dark border border-gold text-gold p-2"><i class="fas fa-paper-plane me-1"></i> Drone Aerial Coverage</span>
                        @endif
                        @if($package->includes_album)
                        <span class="badge bg-dark border border-gold text-gold p-2"><i class="fas fa-book-open me-1"></i> Premium Printed Album</span>
                        @endif
                    </div>
                </div>

                {{-- Highlights Summary Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid rgba(212,175,55,0.2);">
                            <i class="fas fa-clock fa-2x text-gold mb-2"></i>
                            <div class="small text-muted text-uppercase">Duration</div>
                            <div class="fw-bold text-white fs-6">{{ $package->hours ? $package->hours . ' Hours' : 'Full Event Coverage' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid rgba(212,175,55,0.2);">
                            <i class="fas fa-user-friends fa-2x text-gold mb-2"></i>
                            <div class="small text-muted text-uppercase">Team</div>
                            <div class="fw-bold text-white fs-6">{{ $package->photographers ? $package->photographers . ' Professionals' : 'Master Crew' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 text-center rounded-3" style="background:rgba(255,255,255,0.03); border:1px solid rgba(212,175,55,0.2);">
                            <i class="fas fa-photo-video fa-2x text-gold mb-2"></i>
                            <div class="small text-muted text-uppercase">Deliverables</div>
                            <div class="fw-bold text-white fs-6">{{ $package->edited_photos ? $package->edited_photos . '+ Edited Photos' : 'Unlimited Photos' }}</div>
                        </div>
                    </div>
                </div>

                {{-- All Included Deliverables & Features --}}
                <div class="pkg-main-card">
                    <h3 class="font-serif text-white fs-2 mb-2">Complete Package Deliverables</h3>
                    <p class="text-muted mb-4">Here is the exact breakdown of everything included in the <strong>{{ $package->name }}</strong>:</p>

                    <div class="row g-3">
                        @foreach($package->features as $feature)
                        <div class="col-md-6">
                            <div class="feature-check-item {{ !$feature->is_included ? 'opacity-50' : '' }}">
                                @if($feature->is_included)
                                    <i class="fas fa-check-circle text-gold fs-5 mt-1"></i>
                                @else
                                    <i class="fas fa-times-circle text-secondary fs-5 mt-1"></i>
                                @endif
                                <div>
                                    <div class="text-white fw-bold" style="font-size:0.95rem;">{{ $feature->feature }}</div>
                                    <div class="small text-muted">Full high resolution master quality</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Why Choose This Package --}}
                <div class="pkg-main-card">
                    <h3 class="font-serif text-white fs-2 mb-3">Guaranteed Studio Perfection</h3>
                    <div class="row g-4 text-light">
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <i class="fas fa-award fa-2x text-gold"></i>
                                <div>
                                    <h5 class="fw-bold text-white mb-1">Color Graded Excellence</h5>
                                    <p class="small text-muted">Every frame undergoes skin retouching and custom cinematic color grading.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-3">
                                <i class="fas fa-shield-alt fa-2x text-gold"></i>
                                <div>
                                    <h5 class="fw-bold text-white mb-1">Backup & Cloud Delivery</h5>
                                    <p class="small text-muted">Secure password-protected cloud gallery + 64GB premium USB pendrive.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column: Sticky Booking Card --}}
            <div class="col-lg-4">
                <div class="pkg-sidebar-card">
                    
                    @if($package->badge)
                    <div class="badge bg-gold text-dark font-mono text-uppercase px-3 py-1 mb-3 fw-bold">
                        {{ $package->badge }}
                    </div>
                    @elseif($package->is_popular)
                    <div class="badge bg-gold text-dark font-mono text-uppercase px-3 py-1 mb-3 fw-bold">
                        <i class="fas fa-star me-1"></i> Most Popular Choice
                    </div>
                    @endif

                    <h4 class="font-serif text-white fs-3 mb-1">{{ $package->name }}</h4>
                    <p class="small text-muted mb-3">All inclusive transparent package pricing</p>

                    <div class="my-3 pb-3 border-bottom border-secondary border-opacity-25">
                        @if($package->original_price && $package->original_price > $package->price)
                        <div class="text-decoration-line-through text-muted fs-5">
                            {{ $package->formatted_original_price }}
                        </div>
                        @endif
                        
                        <div class="display-4 font-serif text-gold fw-bold my-1">
                            <span style="font-size:2rem; font-family:sans-serif; vertical-align:super;">₹</span>{{ number_format($package->price, 0) }}
                        </div>

                        @if($package->savings_amount > 0)
                        <div class="badge bg-outline-gold text-gold p-2 mt-2 w-100" style="font-size:0.85rem;">
                            🔥 Save ₹{{ number_format($package->savings_amount, 0) }} ({{ $package->discount_percentage }}% OFF)
                        </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 small text-light mb-2">
                            <i class="fas fa-check text-gold"></i> Direct Date Locking & Reservation
                        </div>
                        <div class="d-flex align-items-center gap-2 small text-light mb-2">
                            <i class="fas fa-check text-gold"></i> No Hidden Travel/Tax Fees
                        </div>
                        <div class="d-flex align-items-center gap-2 small text-light">
                            <i class="fas fa-check text-gold"></i> Customizable Deliverables
                        </div>
                    </div>

                    <a href="{{ route('booking.create', ['package_id' => $package->id]) }}" class="btn-book-gold mb-3">
                        <i class="fas fa-calendar-check me-1"></i> Book Package Now
                    </a>

                    <button type="button" class="btn btn-outline-gold w-100 py-3 font-weight-bold rounded-3" @click="quoteOpen = true">
                        <i class="fas fa-paper-plane me-2"></i> Request Custom Quote
                    </button>

                    <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 text-center">
                        <p class="small text-muted mb-2">Need assistance with your dates?</p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('site_phone', '919876543210')) }}" target="_blank" class="text-gold text-decoration-none fw-bold small">
                            <i class="fab fa-whatsapp me-1"></i> Chat with Photographer
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
