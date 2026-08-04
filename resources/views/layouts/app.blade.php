<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Dynamic SEO --}}
    @php
        use App\Models\Setting;
        use App\Models\SeoMeta;
        $pageKey   = $seoPage ?? 'home';
        $seoMeta   = SeoMeta::getForPage($pageKey);
        $siteTitle = Setting::get('site_name', 'Moments Studio');
        $metaTitle = $seoMeta?->title ?? $seoTitle ?? ($siteTitle . ' — ' . Setting::get('site_tagline', 'Capturing Eternal Moments & Luxury Stories'));
        $metaDesc  = $seoMeta?->description ?? $seoDescription ?? Setting::get('seo_description', $siteTitle . ' is a premier luxury wedding photography studio capturing your most precious moments.');
        $metaKeys  = $seoMeta?->keywords ?? $seoKeywords ?? Setting::get('seo_keywords', 'wedding photography, moments studio, wedding films');
        $ogImage   = $seoMeta?->og_image ?? $ogImage ?? Setting::get('site_logo', asset('assets/images/logo.png'));
        $canonUrl  = $seoMeta?->canonical_url ?? url()->current();
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDesc }}">
    <meta name="keywords" content="{{ $metaKeys }}">
    <link rel="canonical" href="{{ $canonUrl }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $siteTitle }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoMeta?->og_title ?? $metaTitle }}">
    <meta property="og:description" content="{{ $seoMeta?->og_description ?? $metaDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ $canonUrl }}">
    <meta property="og:site_name" content="{{ $siteTitle }}">
    <meta property="og:locale" content="en_IN">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoMeta?->twitter_title ?? $metaTitle }}">
    <meta name="twitter:description" content="{{ $seoMeta?->twitter_description ?? $metaDesc }}">
    <meta name="twitter:image" content="{{ $seoMeta?->twitter_image ?? $ogImage }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ Setting::get('site_favicon', asset('assets/images/favicon.png')) }}">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#c9a96e">

    {{-- Bootstrap 5 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    {{-- AOS Animation Library --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    {{-- LightGallery CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lg-zoom.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lg-thumbnail.min.css">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Schema JSON-LD --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "PhotographyBusiness",
        "name": "{{ $siteTitle }}",
        "description": "{{ $metaDesc }}",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ Setting::get('site_address', '123, Diamond Street') }}"
        },
        "telephone": "{{ Setting::get('site_phone', '+91 98765 43210') }}",
        "email": "{{ Setting::get('site_email', 'info@momentsstudio.in') }}",
        "sameAs": [
            "{{ Setting::get('social_instagram', '') }}",
            "{{ Setting::get('social_facebook', '') }}",
            "{{ Setting::get('social_youtube', '') }}"
        ],
        "openingHours": "Mo-Su 09:00-20:00",
        "priceRange": "₹₹₹",
        "image": "{{ $ogImage }}"
    }
    </script>

    @if($seoMeta?->schema_markup)
    <script type="application/ld+json">{!! $seoMeta->schema_markup !!}</script>
    @endif

    @if($seoMeta?->head_scripts)
    {!! $seoMeta->head_scripts !!}
    @endif

    {{-- Google Analytics --}}
    @if(Setting::get('google_analytics'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ Setting::get('google_analytics') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ Setting::get('google_analytics') }}');
    </script>
    @endif

    <style>
        @keyframes pulseLogo {
            0% { transform: scale(1); box-shadow: 0 0 20px rgba(201,169,110,0.4); }
            50% { transform: scale(1.06); box-shadow: 0 0 45px rgba(201,169,110,0.75); }
            100% { transform: scale(1); box-shadow: 0 0 20px rgba(201,169,110,0.4); }
        }
    </style>
    @stack('head')
</head>
<body x-data="momentStudio()" :class="{ 'menu-open': mobileMenuOpen }">

    {{-- Preloader --}}
    <div id="preloader" x-show="loading" x-cloak>
        <div class="preloader-content text-center d-flex flex-column align-items-center justify-content-center">
            <img src="{{ Setting::get('site_logo', asset('assets/images/logo.png')) }}" alt="{{ $siteTitle }}" class="preloader-logo-img" style="height:120px;width:120px;border-radius:50%;object-fit:cover;border:2px solid var(--color-gold);box-shadow:0 0 35px rgba(201,169,110,0.5);animation:pulseLogo 2s infinite ease-in-out;margin:0 auto 1.25rem auto;display:block;">
            <div class="preloader-title text-center" style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;letter-spacing:6px;color:var(--color-gold);text-transform:uppercase;font-weight:600;line-height:1.2;margin:0 auto;">{{ $siteTitle }}</div>
            <div class="preloader-sub text-center" style="font-size:0.75rem;letter-spacing:4px;color:rgba(255,255,255,0.65);text-transform:uppercase;margin:6px auto 0 auto;">Luxury Wedding Photography</div>
            <div class="preloader-bar" style="margin: 1.25rem auto 0 auto;width:180px;height:2px;background:rgba(201,169,110,0.2);overflow:hidden;border-radius:2px;">
                <div class="preloader-progress" style="height:100%;background:linear-gradient(90deg,#a07840,#c9a96e,#e8c98a);animation:preloaderLoad 1.5s ease-in-out forwards;"></div>
            </div>
        </div>
    </div>

    {{-- Search Overlay --}}
    <div class="search-overlay" :class="{ open: searchOpen }" @keydown.escape.window="searchOpen = false">
        <button class="search-overlay-close" @click="searchOpen = false">
            <i class="fas fa-times"></i>
        </button>
        <form action="{{ route('search') }}" method="GET">
            <input
                type="text"
                name="q"
                class="search-overlay-input"
                placeholder="Search..."
                autocomplete="off"
                x-ref="searchInput"
                :autofocus="searchOpen"
            >
        </form>
    </div>

    {{-- Quote Modal --}}
    <div class="quote-modal" x-show="quoteOpen" x-cloak @keydown.escape.window="quoteOpen = false" style="display:none">
        <div class="quote-modal-backdrop" @click="quoteOpen = false"></div>
        <div class="quote-modal-content">
            <button class="btn-nav-icon position-absolute top-0 end-0 m-3" @click="quoteOpen = false" style="font-size:1.25rem;">
                <i class="fas fa-times"></i>
            </button>
            <span class="section-label">Get a Quote</span>
            <h3 class="section-title mb-1" style="font-size:1.75rem;">Let's Capture Your<br><em class="text-gold">Special Moments</em></h3>
            <p class="mt-2 mb-4" style="font-size:0.875rem;color:var(--color-gray);">Fill in your details and we'll get back to you within 24 hours.</p>
            <form action="{{ route('enquiry.store') }}" method="POST" id="quoteForm">
                @csrf
                <input type="hidden" name="source" value="popup">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Your Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email Address *</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
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
                            <label class="form-label">Event Type *</label>
                            <select name="event_type" class="form-control" required>
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
                            <label class="form-label">Location</label>
                            <input type="text" name="subject" class="form-control" placeholder="City / Venue">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Tell us about your vision..."></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary w-100" style="justify-content:center;">
                            <i class="fas fa-paper-plane me-2"></i> Send Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- NAVBAR --}}
    @include('frontend.partials.navbar')

    {{-- Mobile Menu --}}
    <div class="mobile-menu" :class="{ open: mobileMenuOpen }">
        <ul class="mobile-menu-nav">
            <li><a href="{{ url('/') }}" @click="mobileMenuOpen = false">Home</a></li>
            <li><a href="{{ route('about') }}" @click="mobileMenuOpen = false">About</a></li>
            <li><a href="{{ route('services.index') }}" @click="mobileMenuOpen = false">Services</a></li>
            <li><a href="{{ route('gallery.index') }}" @click="mobileMenuOpen = false">Gallery</a></li>
            <li><a href="{{ route('albums.index') }}" @click="mobileMenuOpen = false">Albums</a></li>
            <li><a href="{{ route('packages.index') }}" @click="mobileMenuOpen = false">Packages</a></li>
            <li><a href="{{ route('blog.index') }}" @click="mobileMenuOpen = false">Blog</a></li>
            <li><a href="{{ route('contact') }}" @click="mobileMenuOpen = false">Contact</a></li>
            <li><a href="{{ route('booking.create') }}" @click="mobileMenuOpen = false">Book Now</a></li>
        </ul>
        <div class="mt-3 d-flex gap-2">
            <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}" class="btn btn-outline-gold" target="_blank">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            <a href="{{ route('booking.create') }}" class="btn btn-primary" @click="mobileMenuOpen = false">
                Book Now
            </a>
        </div>
    </div>

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.partials.footer')

    {{-- Floating Buttons --}}
    <div class="floating-btns">
        <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}?text={{ urlencode('Hi! I am interested in your photography services.') }}"
           class="floating-btn floating-btn-whatsapp"
           target="_blank"
           title="Chat on WhatsApp"
           aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <button class="floating-btn floating-btn-top"
                :class="{ show: scrollY > 400 }"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                title="Back to top"
                aria-label="Back to top">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    {{-- CDN Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 800, once: true });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/imagesloaded@5/imagesloaded.pkgd.min.js"></script>

    {{-- Flash messages --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#c9a96e',
                background: '#1a1a1a',
                color: '#fff',
                timer: 4000,
                showConfirmButton: false,
            });
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#c9a96e',
                background: '#1a1a1a',
                color: '#fff',
            });
        });
    </script>
    @endif

    @if($seoMeta?->body_scripts)
    {!! $seoMeta->body_scripts !!}
    @endif

    {{-- Global Package Details Modal --}}
    <style>
        .pkg-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(5, 5, 8, 0.88);
            backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        .pkg-modal-dialog {
            background: linear-gradient(160deg, #181820 0%, #0c0c0e 100%);
            border: 1px solid rgba(201, 169, 110, 0.45);
            border-radius: 22px;
            padding: 2.25rem;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.95), 0 0 60px rgba(201,169,110,0.25);
            position: relative;
        }
        .pkg-modal-close {
            position: absolute;
            top: 1rem;
            right: 1.25rem;
            background: rgba(201,169,110,0.1);
            border: 1px solid rgba(201,169,110,0.3);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            color: #c9a96e;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }
        .pkg-modal-close:hover {
            background: #c9a96e;
            color: #000;
            transform: scale(1.1);
        }
    </style>

    <div x-show="packageModalOpen" x-cloak class="pkg-modal-backdrop" @keydown.escape.window="closePackageModal()">
        <div class="pkg-modal-dialog" @click.away="closePackageModal()">
            <button type="button" class="pkg-modal-close" @click="closePackageModal()">&times;</button>
            <template x-if="activePackage">
                <div>
                    <div class="pkg-modal-header text-center">
                        <span class="badge bg-gold text-dark mb-2 px-3 py-1 font-mono text-uppercase" x-text="activePackage.badge || 'LUXURY COLLECTION'"></span>
                        <h2 class="font-family-serif text-gold display-6 mb-1" x-text="activePackage.name"></h2>
                        <p class="text-light opacity-75 small mb-2" x-text="activePackage.tagline || 'Complete Premium Event Coverage'"></p>
                        
                        <div class="pkg-modal-price my-3 p-3 rounded" style="background: rgba(201,169,110,0.08); border: 1px solid rgba(201,169,110,0.25);">
                            <template x-if="activePackage.original_price">
                                <span class="text-decoration-line-through text-muted me-2" style="font-size:1.1rem;" x-text="activePackage.original_price"></span>
                            </template>
                            <span class="fs-1 font-family-serif text-gold font-weight-bold" x-text="activePackage.price"></span>
                            <template x-if="activePackage.savings">
                                <div class="mt-1">
                                    <span class="badge bg-outline-gold text-gold px-3 py-1" style="font-size:0.85rem;" x-text="activePackage.savings"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="pkg-modal-body my-4" style="max-height: 320px; overflow-y: auto; padding-right: 0.5rem;">
                        <h6 class="text-gold font-family-serif mb-3 border-bottom border-secondary pb-2 text-uppercase tracking-widest"><i class="fas fa-sparkles me-2"></i> All Included Features & Deliverables</h6>
                        <ul class="list-unstyled m-0 p-0">
                            <template x-for="feat in activePackage.features" :key="feat">
                                <li class="py-2 border-bottom border-secondary border-opacity-25 d-flex align-items-center gap-2">
                                    <i class="fas fa-check-circle text-gold me-1"></i>
                                    <span class="text-light" style="font-size:0.925rem;" x-text="feat"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="pkg-modal-footer d-flex gap-2">
                        <a :href="'/booking?package_id=' + activePackage.id" class="btn btn-gold btn-lg flex-grow-1 font-weight-bold text-uppercase" style="letter-spacing:1.5px;">
                            <i class="fas fa-calendar-check me-2"></i> Book Package Now
                        </a>
                        <button type="button" class="btn btn-outline-secondary" @click="closePackageModal()">Close</button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
