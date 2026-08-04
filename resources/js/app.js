/**
 * Moments Studio — Main Application JavaScript
 * Alpine.js components, smooth scroll, interactions
 */

import Alpine from 'alpinejs';
import axios from 'axios';

// Set CSRF token for all AJAX requests
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
axios.defaults.headers.common['Accept'] = 'application/json';

// ============================================================
// MAIN APP COMPONENT (Alpine.js)
// ============================================================
window.momentStudio = function () {
    return {
        // State
        loading:        true,
        mobileMenuOpen: false,
        searchOpen:     false,
        quoteOpen:      false,
        packageModalOpen: false,
        activePackage:   null,
        scrollY:        0,

        openPackageModal(pkg) {
            this.activePackage = pkg;
            this.packageModalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closePackageModal() {
            this.packageModalOpen = false;
            this.activePackage = null;
            document.body.style.overflow = '';
        },

        scrollCarousel(elementId, distance) {
            const el = document.getElementById(elementId);
            if (el) {
                el.scrollBy({ left: distance, behavior: 'smooth' });
            }
        },

        init() {
            // Hide preloader smoothly after page loads
            const hidePreloader = () => {
                setTimeout(() => {
                    this.loading = false;
                    document.body.style.overflow = '';
                }, 800);
            };

            if (document.readyState === 'complete') {
                hidePreloader();
            } else {
                window.addEventListener('load', hidePreloader);
            }

            // Safety fallback hide after 1.5 seconds max
            setTimeout(() => {
                this.loading = false;
                document.body.style.overflow = '';
            }, 1500);

            // Track scroll position
            window.addEventListener('scroll', () => {
                this.scrollY = window.scrollY;
            }, { passive: true });

            // Close mobile menu on resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 992) {
                    this.mobileMenuOpen = false;
                }
            });

            // Prevent body scroll when mobile menu or modal is open
            this.$watch('mobileMenuOpen', (value) => {
                document.body.style.overflow = value ? 'hidden' : '';
            });

            this.$watch('searchOpen', (value) => {
                document.body.style.overflow = value ? 'hidden' : '';
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.searchInput?.focus();
                    });
                }
            });

            this.$watch('quoteOpen', (value) => {
                document.body.style.overflow = value ? 'hidden' : '';
            });
        },
    };
};

// ============================================================
// GALLERY FILTER (Isotope)
// ============================================================
window.initGalleryFilter = function (containerId, filterClass) {
    const container = document.getElementById(containerId);
    if (!container || !window.Isotope) return;

    let iso;

    imagesLoaded(container, function () {
        iso = new Isotope(container, {
            itemSelector: '.gallery-item',
            layoutMode: 'masonry',
            masonry: { columnWidth: '.gallery-item', gutter: 16 },
            transitionDuration: '0.4s',
        });
    });

    document.querySelectorAll('.' + filterClass).forEach(btn => {
        btn.addEventListener('click', function () {
            const filterValue = this.getAttribute('data-filter');
            document.querySelectorAll('.' + filterClass).forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            iso?.arrange({ filter: filterValue });
        });
    });
};

// ============================================================
// MULTI-STEP BOOKING FORM
// ============================================================
window.bookingForm = function (initialData = {}) {
    return {
        currentStep: 1,
        totalSteps: 4,
        form: {
            event_type: initialData.event_type || '',
            package_id: initialData.package_id || '',
            event_date: '',
            event_time: '',
            guest_count: '',
            event_location: '',
            event_city: '',
            client_name: '',
            client_email: '',
            client_phone: '',
            special_requirements: '',
            coupon_code: '',
        },
        couponApplied: false,
        couponDiscount: 0,
        submitting: false,

        get progress() {
            return (this.currentStep / this.totalSteps) * 100;
        },

        nextStep() {
            if (this.validateStep()) {
                if (this.currentStep < this.totalSteps) {
                    this.currentStep++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        },

        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },

        validateStep() {
            // Step-specific validation
            switch (this.currentStep) {
                case 1: return !!this.form.event_type;
                case 2: return !!this.form.event_date && !!this.form.event_location;
                case 3: return !!this.form.client_name && !!this.form.client_email && !!this.form.client_phone;
                default: return true;
            }
        },

        applyCoupon() {
            if (!this.form.coupon_code) return;
            axios.post('/api/coupon/validate', { code: this.form.coupon_code })
                .then(res => {
                    if (res.data.valid) {
                        this.couponApplied = true;
                        this.couponDiscount = res.data.discount;
                        showToast('success', 'Coupon applied! ' + res.data.message);
                    } else {
                        showToast('error', res.data.message || 'Invalid coupon code');
                    }
                })
                .catch(() => showToast('error', 'Failed to validate coupon'));
        },

        async submitForm() {
            if (this.submitting) return;
            this.submitting = true;
            try {
                const formData = new FormData(document.getElementById('bookingForm'));
                const response = await axios.post('/booking', formData);
                if (response.data.success) {
                    window.location.href = '/booking/success/' + response.data.booking_number;
                }
            } catch (error) {
                showToast('error', error.response?.data?.message || 'Something went wrong. Please try again.');
                this.submitting = false;
            }
        },
    };
};

// ============================================================
// NEWSLETTER FORM
// ============================================================
document.addEventListener('DOMContentLoaded', function () {
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const email = document.getElementById('newsletterEmail')?.value;
            if (!email) return;

            axios.post('/newsletter/subscribe', { email })
                .then(res => {
                    showToast('success', res.data.message || 'Thank you for subscribing!');
                    newsletterForm.reset();
                })
                .catch(err => {
                    showToast('error', err.response?.data?.message || 'Subscription failed. Please try again.');
                });
        });
    }

    // Quote form AJAX
    const quoteForm = document.getElementById('quoteForm');
    if (quoteForm) {
        quoteForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(quoteForm);
            axios.post(quoteForm.action, formData)
                .then(res => {
                    if (res.data.success || res.status === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Sent!',
                            text: 'Thank you! We will get back to you within 24 hours.',
                            confirmButtonColor: '#c9a96e',
                            background: '#1a1a1a',
                            color: '#fff',
                        });
                        quoteForm.reset();
                        Alpine.store('quoteOpen', false);
                    }
                })
                .catch(() => showToast('error', 'Failed to send request. Please try again.'));
        });
    }

    // Smooth scroll for hash links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Lazy load images with IntersectionObserver
    if ('IntersectionObserver' in window) {
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '50px 0px' });

        lazyImages.forEach(img => imageObserver.observe(img));
    }

    // Reveal animations (IntersectionObserver fallback for AOS)
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal-up, .reveal-left, .reveal-right, .reveal-scale').forEach(el => {
            revealObserver.observe(el);
        });
    }
});

// ============================================================
// UTILITIES
// ============================================================
window.showToast = function (type, message) {
    if (typeof Swal !== 'undefined') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#1a1a1a',
            color: '#fff',
        });
        Toast.fire({ icon: type, title: message });
    } else {
        alert(message);
    }
};

window.copyToClipboard = function (text) {
    navigator.clipboard.writeText(text).then(() => showToast('success', 'Copied!'));
};

// ============================================================
// ALPINE INIT
// ============================================================
window.Alpine = Alpine;
Alpine.start();
