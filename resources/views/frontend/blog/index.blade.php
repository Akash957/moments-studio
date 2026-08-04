@extends('layouts.app')
@php
    $seoTitle = 'Wedding Photography Blog — Tips & Inspiration | Moments Studio';
    $seoDescription = 'Expert tips on choosing wedding photographers, venue guides across India, pre-wedding pose ideas, and behind the scenes stories.';
@endphp

@section('content')

{{-- Hero --}}
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1545156521-77bd85671d30?w=1920');">
    <div class="container">
        <div class="page-hero-content text-center">
            <span class="section-label">Stories & Advice</span>
            <h1 class="page-hero-title">Wedding Journal & Blog</h1>
            <nav class="breadcrumb justify-content-center">
                <span class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></span>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Blog</span>
            </nav>
        </div>
    </div>
</section>

{{-- Main Blog Section --}}
<section class="section section-dark">
    <div class="container">
        <div class="row g-5">

            {{-- Articles --}}
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($blogs as $blog)
                    <div class="col-md-6" data-aos="fade-up">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card d-block h-100">
                            <div class="blog-card-img-wrap">
                                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" class="blog-card-img" loading="lazy">
                                @if($blog->category)
                                <span class="blog-card-category">{{ $blog->category->name }}</span>
                                @endif
                            </div>
                            <div class="blog-card-body">
                                <div class="blog-card-meta">
                                    <span><i class="fas fa-calendar-alt"></i> {{ $blog->published_at?->format('M d, Y') }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $blog->reading_time }} min</span>
                                </div>
                                <h3 class="blog-card-title">{{ $blog->title }}</h3>
                                <p class="blog-card-excerpt">{{ $blog->excerpt_limited }}</p>
                                <span class="btn-arrow">
                                    Read Article
                                    <span class="arrow-circle"><i class="fas fa-arrow-right"></i></span>
                                </span>
                            </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-gray">No blog posts found.</p>
                    </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $blogs->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="contact-card sticky-top" style="top:100px;">
                    {{-- Search --}}
                    <div class="mb-4">
                        <h4 class="font-primary text-gold mb-3" style="font-size:1.125rem;">Search Articles</h4>
                        <form action="{{ route('blog.index') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search blog..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>

                    {{-- Categories --}}
                    <div class="mb-4">
                        <h4 class="font-primary text-gold mb-3" style="font-size:1.125rem;">Categories</h4>
                        <ul class="list-unstyled mb-0">
                            @foreach($categories as $cat)
                            <li class="mb-2">
                                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="text-white hover-gold text-decoration-none d-flex align-items-center justify-content-between" style="font-size:0.875rem;">
                                    <span><i class="fas fa-folder me-2 text-gold"></i>{{ $cat->name }}</span>
                                    <span class="badge bg-dark-3 text-gold">{{ $cat->blogs_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Featured Posts --}}
                    @if($featured->count() > 0)
                    <div>
                        <h4 class="font-primary text-gold mb-3" style="font-size:1.125rem;">Popular Posts</h4>
                        @foreach($featured as $fPost)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ $fPost->featured_image_url }}" alt="{{ $fPost->title }}" style="width:60px;height:60px;object-fit:cover;border-radius:var(--radius-md);">
                            <div>
                                <a href="{{ route('blog.show', $fPost->slug) }}" class="text-white hover-gold text-decoration-none fw-500" style="font-size:0.875rem;line-height:1.3;display:block;">
                                    {{ Str::limit($fPost->title, 45) }}
                                </a>
                                <span style="font-size:0.75rem;color:var(--color-gray);">{{ $fPost->published_at?->format('M d, Y') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
