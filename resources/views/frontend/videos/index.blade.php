@extends('layouts.app')

@section('title', 'Cinematic Wedding Films & Video Portfolio')
@section('meta_description', 'Watch luxury cinematic wedding trailers, teasers, and wedding films crafted by ' . \App\Models\Setting::get('site_name', 'Moments Studio') . '.')

@section('content')
{{-- Hero Header --}}
<section class="page-hero bg-dark text-white text-center py-5" style="padding-top: 160px !important;">
    <div class="container py-4">
        <span class="section-label text-gold font-weight-bold">Cinematic Stories</span>
        <h1 class="display-4 font-family-serif text-gold font-weight-bold mb-3">Cinema & Films</h1>
        <p class="lead text-light max-w-700 mx-auto" style="opacity: 0.85;">
            Immerse yourself in breathtaking 4K wedding trailers, emotional teasers, and high-production cinematic films by {{ \App\Models\Setting::get('site_name', 'Moments Studio') }}.
        </p>
    </div>
</section>

{{-- Video Grid Section --}}
<section class="section section-dark py-5">
    <div class="container">
        <div class="row g-4">
            @forelse($videos as $video)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 100 }}">
                <div class="video-card card bg-black text-white border-warning shadow-lg h-100 overflow-hidden" style="border-radius: 16px; border: 1px solid rgba(201, 169, 110, 0.3);">
                    <div class="video-thumb-container position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="img-fluid w-100 h-100" style="object-fit: cover; transition: transform 0.5s ease;">
                        <div class="video-overlay position-absolute inset-0 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.45); transition: background 0.3s ease;">
                            <a href="{{ route('videos.show', $video->slug ?? $video->id) }}" class="play-btn-circle rounded-circle bg-gold text-dark d-flex align-items-center justify-content-center shadow-lg" style="width: 60px; height: 60px; text-decoration: none; transition: transform 0.3s ease;">
                                <i class="fas fa-play fa-lg ms-1" style="color: #0a0a0a;"></i>
                            </a>
                        </div>
                        @if($video->duration)
                        <span class="badge bg-dark text-gold position-absolute bottom-0 end-0 m-2 px-2 py-1" style="border: 1px solid rgba(201, 169, 110, 0.4);">
                            <i class="far fa-clock me-1"></i> {{ $video->duration }}
                        </span>
                        @endif
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="h5 card-title font-family-serif text-white mb-2">
                                <a href="{{ route('videos.show', $video->slug ?? $video->id) }}" class="text-white text-decoration-none hover-gold">
                                    {{ $video->title }}
                                </a>
                            </h3>
                            @if($video->location)
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt text-gold me-1"></i> {{ $video->location }}
                            </p>
                            @endif
                            @if($video->description)
                            <p class="card-text text-light small" style="opacity: 0.75; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $video->description }}
                            </p>
                            @endif
                        </div>
                        <div class="mt-3 pt-3 border-top border-secondary d-flex justify-content-between align-items-center">
                            <span class="text-gold small"><i class="fas fa-film me-1"></i> 4K Ultra HD</span>
                            <a href="{{ route('videos.show', $video->slug ?? $video->id) }}" class="btn btn-sm btn-outline-gold">
                                Watch Film <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 rounded-4" style="background: #181818; border: 1px dashed rgba(201, 169, 110, 0.3);">
                    <i class="fas fa-film fa-3x text-gold mb-3"></i>
                    <h3 class="h4 text-white font-family-serif">No Cinematic Films Available Yet</h3>
                    <p class="text-muted max-w-500 mx-auto">We are currently editing and uploading new 4K wedding films. Please check back soon or explore our photo galleries!</p>
                    <a href="{{ route('gallery.index') }}" class="btn btn-gold mt-3">Browse Photo Gallery</a>
                </div>
            </div>
            @endforelse
        </div>

        @if($videos->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $videos->links() }}
        </div>
        @endif
    </div>
</section>

<style>
.video-card:hover .video-thumb-container img {
    transform: scale(1.08);
}
.video-card:hover .play-btn-circle {
    transform: scale(1.15);
    background-color: #ffffff !important;
}
.hover-gold:hover {
    color: #c9a96e !important;
}
</style>
@endsection
