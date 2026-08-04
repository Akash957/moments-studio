@php
use App\Models\Setting;
use App\Models\Service;
$footerServices = Service::active()->limit(6)->get();
@endphp

<footer class="footer">

    {{-- Newsletter Strip --}}
    <div style="background:linear-gradient(90deg,rgba(201,169,110,0.08),rgba(201,169,110,0.03));border-top:1px solid rgba(201,169,110,0.12);border-bottom:1px solid rgba(201,169,110,0.12);padding:2rem 0;">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <span class="section-label mb-1">Stay Connected</span>
                    <h4 class="font-primary mb-0" style="font-size:1.5rem;">Subscribe Our Newsletter</h4>
                    <p class="mt-1 mb-0" style="font-size:0.875rem;color:var(--color-gray);">Get updates on weddings, tips, and exclusive offers.</p>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="footer-newsletter-form" id="newsletterForm">
                        @csrf
                        <input type="email" name="email" class="footer-newsletter-input" placeholder="Your email address..." required id="newsletterEmail">
                        <button type="submit" class="footer-newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Top --}}
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">

                {{-- About Column --}}
                <div class="col-lg-4 col-md-6">
                    <a href="{{ url('/') }}" class="footer-logo d-flex align-items-center gap-2">
                        <img src="{{ Setting::get('site_logo', asset('assets/images/logo.png')) }}" alt="{{ Setting::get('site_name', 'Moments Studio') }}" style="height:55px;width:55px;border-radius:50%;object-fit:cover;border:1px solid var(--color-gold);" onerror="this.style.display='none'">
                        <div class="name">{{ Setting::get('site_name', 'Moments Studio') }}</div>
                    </a>
                    <p class="footer-desc">
                        {{ Setting::get('site_description', 'Premium wedding photography studio capturing your most precious moments with artistry, creativity, and passion.') }}
                    </p>

                    {{-- Contact Info --}}
                    <div class="mb-3">
                        <div class="footer-contact-item">
                            <i class="fas fa-phone"></i>
                            <a href="tel:{{ Setting::get('site_phone', '+919876543210') }}" style="color:var(--color-gray);">
                                {{ Setting::get('site_phone', '+91 98765 43210') }}
                            </a>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <a href="mailto:{{ Setting::get('site_email', 'info@momentsstudio.in') }}" style="color:var(--color-gray);">
                                {{ Setting::get('site_email', 'info@momentsstudio.in') }}
                            </a>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ Setting::get('site_address', '123, Diamond Street, New York, USA') }}</span>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    <div class="footer-socials">
                        @if(Setting::get('social_instagram'))
                        <a href="{{ Setting::get('social_instagram') }}" class="footer-social-btn" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if(Setting::get('social_facebook'))
                        <a href="{{ Setting::get('social_facebook') }}" class="footer-social-btn" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if(Setting::get('social_youtube'))
                        <a href="{{ Setting::get('social_youtube') }}" class="footer-social-btn" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        @endif
                        @if(Setting::get('social_pinterest'))
                        <a href="{{ Setting::get('social_pinterest') }}" class="footer-social-btn" target="_blank" rel="noopener noreferrer" aria-label="Pinterest">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                        @endif
                        <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}" class="footer-social-btn" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('gallery.index') }}">Gallery</a></li>
                        <li><a href="{{ route('albums.index') }}">Albums</a></li>
                        <li><a href="{{ route('packages.index') }}">Packages</a></li>
                        <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                {{-- Services --}}
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Our Services</h5>
                    <ul class="footer-links">
                        @php
                            $footerCategories = \App\Models\ServiceCategory::active()->limit(8)->get();
                        @endphp
                        @foreach($footerCategories as $cat)
                        <li>
                            <a href="{{ route('services.show', $cat->slug) }}">{{ $cat->name }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Support --}}
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Support</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('faq.index') }}">FAQ</a></li>
                        <li><a href="{{ route('booking.create') }}">Book Session</a></li>
                        <li><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
                        <li><a href="{{ route('awards.index') }}">Awards</a></li>
                        <li><a href="{{ route('team.index') }}">Our Team</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Contact Info</h5>
                    <p style="font-size:0.875rem;color:var(--color-gray);line-height:1.8;">
                        <strong style="color:var(--color-off-white);">{{ Setting::get('site_address', '123, Diamond Street') }}</strong><br>
                        {{ Setting::get('site_city', 'New York, USA') }}
                    </p>
                    <div style="margin-top:1rem;">
                        <div style="font-size:0.8125rem;color:var(--color-gray);margin-bottom:0.5rem;">
                            <i class="fas fa-clock me-2" style="color:var(--color-gold);"></i>Mon–Sun: 9AM – 8PM
                        </div>
                        <div style="font-size:0.8125rem;color:var(--color-gray);">
                            <i class="fab fa-whatsapp me-2" style="color:var(--color-gold);"></i>
                            <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}" target="_blank" style="color:var(--color-gray);">
                                WhatsApp Us
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Partners Bar --}}
    <div class="partners-bar">
        <div class="container">
            <div class="partners-grid">
                <span class="partner-logo">Canon</span>
                <span class="partner-logo">Nikon</span>
                <span class="partner-logo">Sony</span>
                <span class="partner-logo">DJI</span>
                <span class="partner-logo">Profoto</span>
                <span class="partner-logo">Godox</span>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">
                    &copy; {{ date('Y') }} <a href="{{ url('/') }}" style="color:var(--color-gold);">{{ Setting::get('site_name', 'Moments Studio') }}</a>. All Rights Reserved.
                    <span style="margin-left:0.5rem;color:rgba(255,255,255,0.3);">|</span>
                    <span style="margin-left:0.5rem;">Designed with <i class="fas fa-heart" style="color:var(--color-gold);font-size:0.75rem;"></i> by {{ Setting::get('site_name', 'Moments Studio') }}</span>
                </p>
                <ul class="footer-bottom-links">
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms</a></li>
                    <li><a href="{{ route('sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
        </div>
    </div>

</footer>
