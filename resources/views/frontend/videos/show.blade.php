@extends('layouts.app')

@section('title', ($video->title ?? 'Cinematic Film') . ' | ' . \App\Models\Setting::get('site_name', 'Moments Studio'))
@section('meta_description', Str::limit(strip_tags($video->description ?? ('Watch this wedding film by ' . \App\Models\Setting::get('site_name', 'Moments Studio'))), 150))

@section('content')
<section class="video-detail-section py-5" style="padding-top: 160px !important;">
    <div class="container">
        @if(!$video)
        <div class="text-center py-5">
            <div class="p-5 rounded-4" style="background: #181818; border: 1px dashed rgba(201, 169, 110, 0.3);">
                <i class="fas fa-exclamation-circle fa-3x text-gold mb-3"></i>
                <h2 class="h3 text-white font-family-serif">Film Not Found</h2>
                <p class="text-muted">The requested video film does not exist or has been moved.</p>
                <a href="{{ route('videos.index') }}" class="btn btn-gold mt-3">Back to All Films</a>
            </div>
        </div>
        @else

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-gold text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('videos.index') }}" class="text-gold text-decoration-none">Films</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $video->title }}</li>
            </ol>
        </nav>

        {{-- Embedded Video Player Container --}}
        <div class="video-player-wrapper shadow-lg mb-4 rounded-4 overflow-hidden" style="background: #000; border: 1px solid rgba(201, 169, 110, 0.3);">
            @if(str_contains($video->embed_url, 'embed') || str_contains($video->embed_url, 'vimeo') || str_contains($video->embed_url, 'youtube'))
            <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                <iframe src="{{ $video->embed_url }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe>
            </div>
            @else
            <video controls controlsList="nodownload" class="w-100 d-block" style="max-height: 600px; object-fit: contain; background: #000;" poster="{{ $video->thumbnail_url }}">
                <source src="{{ $video->embed_url }}" type="video/mp4">
                Your browser does not support HTML5 video playback.
            </video>
            @endif
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <h1 class="display-5 text-gold font-family-serif mb-3">{{ $video->title }}</h1>
                <div class="d-flex flex-wrap gap-3 align-items-center text-muted mb-4 pb-3 border-bottom border-secondary">
                    @if($video->location)
                    <span><i class="fas fa-map-marker-alt text-gold me-1"></i> {{ $video->location }}</span>
                    @endif
                    @if($video->event_date)
                    <span><i class="far fa-calendar-alt text-gold me-1"></i> {{ $video->event_date->format('F d, Y') }}</span>
                    @endif
                    @if($video->duration)
                    <span><i class="far fa-clock text-gold me-1"></i> {{ $video->duration }}</span>
                    @endif
                </div>

                <div class="video-description text-light lead fs-6" style="opacity: 0.9; line-height: 1.8;">
                    {!! nl2br(e($video->description)) !!}
                </div>
            </div>

            <div class="col-lg-4">
                <div class="p-4 rounded-4 bg-dark border border-secondary">
                    <h3 class="h5 text-gold font-family-serif mb-3"><i class="fas fa-video me-2"></i> Book Video Coverage</h3>
                    <p class="text-light small" style="opacity:0.8;">Want us to capture your wedding or event with cinematic 4K video storytelling?</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-gold w-100 py-3 font-weight-bold">
                        Check Date & Reserve <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>

                @if($relatedVideos->count() > 0)
                <div class="mt-4">
                    <h4 class="h5 text-white font-family-serif mb-3 border-bottom pb-2" style="border-color: rgba(201, 169, 110, 0.3) !important;">More Films</h4>
                    @foreach($relatedVideos as $rel)
                    <div class="d-flex mb-3 gap-3">
                        <a href="{{ route('videos.show', $rel->slug ?? $rel->id) }}" class="flex-shrink-0 position-relative rounded overflow-hidden" style="width: 110px; height: 70px;">
                            <img src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" class="w-100 h-100" style="object-fit: cover;">
                        </a>
                        <div>
                            <h5 class="h6 mb-1">
                                <a href="{{ route('videos.show', $rel->slug ?? $rel->id) }}" class="text-white text-decoration-none hover-gold">
                                    {{ $rel->title }}
                                </a>
                            </h5>
                            <span class="text-muted small">{{ $rel->location }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
