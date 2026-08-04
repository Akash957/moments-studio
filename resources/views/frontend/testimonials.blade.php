@extends('layouts.app')
@php
    $seoTitle = 'Client Testimonials & Reviews — Moments Studio';
    $seoDescription = 'Read reviews from real couples who trusted Moments Studio to document their weddings and celebrations.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Client Love</span>
            <h1 class="page-hero-title">Testimonials</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Testimonials</span>
            </nav>
        </div>
    </div>
</section>

{{-- Testimonials Grid --}}
<section class="section section-dark">
    <div class="container">
        <div class="row g-4">
            @foreach($testimonials as $t)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="testimonial-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="testimonial-quote">"</div>
                        <div class="testimonial-stars mb-3">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $t->rating ? 'text-gold' : '' }}" style="{{ $i > $t->rating ? 'opacity:0.2' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="testimonial-text">{{ $t->review }}</p>
                    </div>
                    <div class="testimonial-client mt-4">
                        <img src="{{ $t->client_image_url }}" alt="{{ $t->client_name }}" class="testimonial-avatar" loading="lazy">
                        <div>
                            <div class="testimonial-client-name">{{ $t->client_name }}</div>
                            @if($t->wedding_location)
                            <div class="testimonial-client-location"><i class="fas fa-map-marker-alt me-1"></i>{{ $t->wedding_location }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $testimonials->links() }}
        </div>
    </div>
</section>

@endsection
