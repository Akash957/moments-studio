@extends('layouts.app')
@php
    $seoTitle = $blog->title . ' — Moments Studio Blog';
    $seoDescription = $blog->excerpt;
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('{{ $blog->featured_image_url }}');">
    <div class="container">
        <div class="page-hero-content text-center" style="max-width:800px;margin:0 auto;">
            @if($blog->category)
            <span class="section-label">{{ $blog->category->name }}</span>
            @endif
            <h1 class="page-hero-title">{{ $blog->title }}</h1>
            <div class="d-flex align-items-center justify-content-center gap-3 mt-3 text-gold" style="font-size:0.875rem;">
                <span><i class="fas fa-user me-1"></i> {{ $blog->author?->name ?? 'Moments Studio' }}</span>
                <span>•</span>
                <span><i class="fas fa-calendar-alt me-1"></i> {{ $blog->published_at?->format('F d, Y') }}</span>
                <span>•</span>
                <span><i class="fas fa-eye me-1"></i> {{ number_format($blog->views_count) }} views</span>
            </div>
        </div>
    </div>
</section>

{{-- Article Content --}}
<section class="section section-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="contact-card p-4 p-md-5">

                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="img-fluid rounded-gold mb-4 w-100" style="max-height:450px;object-fit:cover;">

                    {{-- Body --}}
                    <div style="color:rgba(255,255,255,0.9);line-height:1.9;font-size:1.0625rem;" class="blog-article-content mb-5">
                        {!! $blog->content !!}
                    </div>

                    {{-- Tags & Share --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 py-3" style="border-top:1px solid rgba(201,169,110,0.15);border-bottom:1px solid rgba(201,169,110,0.15);">
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-gold" style="font-size:0.875rem;"><i class="fas fa-tags me-1"></i> Tags:</span>
                            @foreach($blog->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="badge bg-dark-3 text-white text-decoration-none px-2 py-1" style="font-size:0.75rem;">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-gray" style="font-size:0.875rem;">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn-social-mini"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="btn-social-mini"><i class="fab fa-twitter"></i></a>
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="btn-social-mini"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>

                    {{-- Next Prev --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        @if($prev)
                        <a href="{{ route('blog.show', $prev->slug) }}" class="btn-arrow">
                            <span class="arrow-circle"><i class="fas fa-arrow-left"></i></span> Previous
                        </a>
                        @else <div></div> @endif

                        @if($next)
                        <a href="{{ route('blog.show', $next->slug) }}" class="btn-arrow">
                            Next <span class="arrow-circle"><i class="fas fa-arrow-right"></i></span>
                        </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
