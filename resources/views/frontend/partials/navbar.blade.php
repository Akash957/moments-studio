<nav class="navbar-main" :class="{ scrolled: scrollY > 80, transparent: scrollY <= 80 }" id="mainNavbar">
    <div class="container-fluid px-4 px-lg-5">
        <div class="navbar-inner">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="navbar-logo d-flex align-items-center gap-2">
                @php
                    $logoUrl = \App\Models\Setting::get('site_logo');
                    if (!$logoUrl || str_contains(strtolower($logoUrl), 'love')) {
                        $logoUrl = asset('assets/images/logo.png');
                    }
                    $brandName = \App\Models\Setting::get('site_name');
                    if (!$brandName || str_contains(strtolower($brandName), 'love')) {
                        $brandName = 'Moments Studio';
                    }
                    $parts = explode(' ', $brandName, 2);
                    $firstName = $parts[0] ?? 'Moments';
                    $secondName = $parts[1] ?? 'Studio';
                @endphp
                <img src="{{ $logoUrl }}" alt="{{ $brandName }}" style="height:48px;width:48px;border-radius:50%;object-fit:cover;border:1px solid var(--color-gold);" onerror="this.style.display='none'">
                <div class="logo-text">
                    <span class="logo-name">{{ $firstName }}</span>
                    <span class="logo-studio">{{ $secondName }}</span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <ul class="navbar-nav-links">
                <li>
                    <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
                </li>
                <li>
                    <a href="{{ route('services.index') }}" class="{{ request()->is('services*') ? 'active' : '' }}">
                        Services <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="navbar-dropdown">
                        @php
                            $dynamicCategories = \App\Models\ServiceCategory::active()->get();
                        @endphp
                        @forelse($dynamicCategories as $cat)
                        <a href="{{ route('services.show', $cat->slug) }}">
                            <i class="{{ $cat->icon ?? 'fas fa-camera' }}"></i> {{ $cat->name }}
                        </a>
                        @empty
                        <a href="{{ route('services.index') }}"><i class="fas fa-camera"></i> All Services</a>
                        @endforelse
                    </div>
                </li>
                <li>
                    <a href="{{ route('gallery.index') }}" class="{{ request()->is('gallery*') ? 'active' : '' }}">
                        Gallery <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="navbar-dropdown">
                        <a href="{{ route('gallery.index') }}"><i class="fas fa-images"></i> Gallery</a>
                        <a href="{{ route('albums.index') }}"><i class="fas fa-book-open"></i> Albums</a>
                        <a href="{{ route('videos.index') }}"><i class="fas fa-video"></i> Videos</a>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ request()->is('pages*') ? 'active' : '' }}">
                        Pages <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="navbar-dropdown">
                        <a href="{{ route('packages.index') }}"><i class="fas fa-box"></i> Packages</a>
                        <a href="{{ route('testimonials.index') }}"><i class="fas fa-star"></i> Testimonials</a>
                        <a href="{{ route('awards.index') }}"><i class="fas fa-award"></i> Awards</a>
                        <a href="{{ route('team.index') }}"><i class="fas fa-users"></i> Our Team</a>
                        <a href="{{ route('faq.index') }}"><i class="fas fa-question-circle"></i> FAQ</a>
                        <a href="{{ route('booking.create') }}"><i class="fas fa-calendar-check"></i> Book Now</a>
                    </div>
                </li>
                <li>
                    <a href="{{ route('blog.index') }}" class="{{ request()->is('blog*') ? 'active' : '' }}">Blog</a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
                </li>
            </ul>

            {{-- Navbar Actions --}}
            <div class="navbar-actions">
                {{-- Book Now --}}
                <a href="{{ route('booking.create') }}" class="btn-book-now d-none d-md-flex">
                    Book Now
                </a>

                {{-- Get Quote --}}
                <button class="btn btn-outline-gold d-none d-xl-flex" @click="quoteOpen = true" style="padding:0.45rem 1rem;font-size:0.75rem;">
                    Get Quote
                </button>

                {{-- Hamburger --}}
                <button class="navbar-hamburger" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu" id="hamburger">
                    <span :style="mobileMenuOpen ? 'transform: rotate(45deg) translate(5px, 5px)' : ''"></span>
                    <span :style="mobileMenuOpen ? 'opacity: 0' : ''"></span>
                    <span :style="mobileMenuOpen ? 'transform: rotate(-45deg) translate(5px, -5px)' : ''"></span>
                </button>
            </div>

        </div>
    </div>
</nav>
