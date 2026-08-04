@extends('layouts.app')
@php
    $seoTitle = $album->title . ' — Moments Studio Wedding Album';
    $seoDescription = $album->description;
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('{{ $album->cover_image_url }}');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">{{ $album->couple_names ?? 'Wedding Story' }}</span>
            <h1 class="page-hero-title">{{ $album->title }}</h1>
            <p style="color:var(--color-gold);font-family:var(--font-secondary);font-size:1.25rem;" class="mt-2">
                <i class="fas fa-map-marker-alt me-1"></i> {{ $album->location }}
                @if($album->event_date) | {{ $album->event_date->format('F d, Y') }} @endif
            </p>
            <nav class="breadcrumb justify-content-center mt-3">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item"><a href="{{ route('albums.index') }}">Albums</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">{{ $album->title }}</span>
            </nav>
        </div>
    </div>
</section>

{{-- Album Description & Gallery --}}
<section class="section section-dark">
    <div class="container">

        @if($album->description)
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <p style="font-family:var(--font-secondary);font-size:1.25rem;color:rgba(255,255,255,0.85);line-height:1.8;font-style:italic;">
                    "{{ $album->description }}"
                </p>
                <div class="gold-divider"><span>❀</span></div>
            </div>
        </div>
        @endif

        {{-- Lightgallery grid --}}
        <div class="gallery-masonry" id="albumLightgallery">
            @foreach($album->images as $img)
            <div class="gallery-item"
                 data-src="{{ asset('storage/' . $img->image) }}"
                 data-sub-html="<h4>{{ $album->title }}</h4><p>{{ $img->caption }}</p>">
                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $album->title }}" loading="lazy">
                <div class="gallery-item-overlay">
                    <div class="gallery-item-zoom">
                        <i class="fas fa-expand-alt"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Next / Prev Navigation --}}
        <div class="d-flex justify-content-between align-items-center mt-5 pt-4" style="border-top:1px solid rgba(201,169,110,0.15);">
            <a href="{{ route('albums.index') }}" class="btn btn-outline-gold">
                <i class="fas fa-arrow-left me-2"></i> All Albums
            </a>
            <button class="btn btn-primary" @click="quoteOpen = true">
                <i class="fas fa-calendar-check me-2"></i> Book Similar Shoot
            </button>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('albumLightgallery');
    if (grid) {
        lightGallery(grid, {
            selector: '.gallery-item',
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
        });
    }
});
</script>
@endpush
