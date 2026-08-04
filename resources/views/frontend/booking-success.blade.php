@extends('layouts.app')
@php
    $seoTitle = 'Booking Confirmed — Moments Studio';
@endphp

@section('content')

<section class="section section-dark min-vh-100 d-flex align-items-center">
    <div class="container text-center" style="max-width:700px;">
        <div class="contact-card p-5" data-aos="zoom-in">
            <div style="width:80px;height:80px;background:var(--color-gold-pale);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--color-gold);font-size:2.5rem;margin:0 auto 1.5rem;">
                <i class="fas fa-check-circle"></i>
            </div>
            <span class="section-label">Reservation Received</span>
            <h1 class="font-primary text-white mb-3" style="font-size:2.5rem;">Thank You, {{ $booking->client_name }}!</h1>
            <p style="color:var(--color-gray);font-size:1.125rem;line-height:1.8;" class="mb-4">
                Your booking request has been submitted successfully. Your reference booking number is:
            </p>
            <div style="background:var(--color-dark-3);border:1px dashed var(--color-gold);padding:1rem 2rem;border-radius:var(--radius-lg);display:inline-block;" class="mb-4">
                <span style="font-family:var(--font-primary);font-size:1.75rem;font-weight:700;color:var(--color-gold);letter-spacing:0.1em;">
                    {{ $booking->booking_number }}
                </span>
            </div>

            <p style="font-size:0.875rem;color:rgba(255,255,255,0.7);" class="mb-4">
                We have dispatched a confirmation email to <strong>{{ $booking->client_email }}</strong>. Our team will contact you shortly to finalize details.
            </p>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Return Home
                </a>
                <a href="https://wa.me/{{ Setting::get('site_whatsapp', '919876543210') }}?text={{ urlencode('Hi! I submitted booking number ' . $booking->booking_number) }}" target="_blank" class="btn btn-outline-gold">
                    <i class="fab fa-whatsapp me-2"></i> WhatsApp Support
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
