@extends('layouts.app')
@php
    $seoTitle = 'Photo Gallery — Moments Studio Luxury Wedding Portfolio';
    $seoDescription = 'Explore our portfolio of candid wedding photography, pre-wedding shoots, engagement portraits, and high-fashion wedding imagery.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Visual Storytelling</span>
            <h1 class="page-hero-title">Photo Gallery</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Gallery</span>
            </nav>
        </div>
    </div>
</section>

{{-- Gallery Section --}}
<section class="section section-dark" id="gallerySection">
    <div class="container-fluid px-4 px-lg-5">

        {{-- Filters --}}
        <div class="gallery-filter">
            <a href="{{ route('gallery.index') }}" class="gallery-filter-btn {{ !$category || $category === 'all' ? 'active' : '' }}">
                All Photos
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('gallery.index', ['category' => $cat->slug]) }}" class="gallery-filter-btn {{ $category === $cat->slug ? 'active' : '' }}">
                {{ $cat->name }} ({{ $cat->galleries_count }})
            </a>
            @endforeach
        </div>

        {{-- Masonry Grid --}}
        <div class="gallery-masonry" id="lightgalleryGrid">
            @forelse($galleries as $photo)
            <div class="gallery-item"
                 data-src="{{ $photo->image_url }}"
                 data-sub-html="<h4>{{ $photo->title ?? 'Moments Studio' }}</h4><p>{{ $photo->category?->name }}</p>">
                <img src="{{ $photo->thumbnail_url }}" alt="{{ $photo->title }}" loading="lazy">
                <div class="gallery-item-overlay">
                    <div class="gallery-item-zoom">
                        <i class="fas fa-expand-alt"></i>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-gray" style="font-size:1.125rem;">No photos available in this category yet.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $galleries->links() }}
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('lightgalleryGrid');
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
