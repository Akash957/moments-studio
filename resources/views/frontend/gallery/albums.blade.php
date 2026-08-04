@extends('layouts.app')
@php
    $seoTitle = 'Wedding Albums — Moments Studio Real Wedding Stories';
    $seoDescription = 'Browse full real wedding album collections from Jaipur palaces to Goa beaches captured by Moments Studio.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1606216794074-735e91aa2c92?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Real Wedding Stories</span>
            <h1 class="page-hero-title">Wedding Albums</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Albums</span>
            </nav>
        </div>
    </div>
</section>

{{-- Albums Grid --}}
<section class="section section-dark">
    <div class="container">

        <div class="row g-4">
            @foreach($albums as $album)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('albums.show', $album->slug) }}" class="album-card d-block">
                    <img src="{{ $album->cover_image_url }}" alt="{{ $album->title }}" class="album-card-img" loading="lazy">
                    <div class="album-card-overlay">
                        <div class="album-card-category">{{ $album->category?->name ?? 'Wedding' }}</div>
                        <h3 class="album-card-title">{{ $album->title }}</h3>
                        <div class="album-card-info">
                            <i class="fas fa-map-marker-alt me-1 text-gold"></i>{{ $album->location }}
                            @if($album->event_date)
                            <span class="ms-3"><i class="fas fa-calendar me-1 text-gold"></i>{{ $album->event_date->format('M Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="album-card-count">{{ $album->images->count() }} Photos</div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $albums->links() }}
        </div>

    </div>
</section>

@endsection
