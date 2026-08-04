@extends('layouts.app')
@php $seoTitle = 'Our Team — Moments Studio Photographers'; @endphp
@section('content')
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=1920');">
    <div class="container text-center page-hero-content">
        <span class="section-label">The Artists</span>
        <h1 class="page-hero-title">Meet Our Team</h1>
    </div>
</section>
<section class="section section-dark">
    <div class="container">
        <div class="row g-4">
            @foreach($team as $member)
            <div class="col-lg-3 col-md-6" data-aos="fade-up">
                <div class="team-card">
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="team-card-img" loading="lazy">
                    <div class="team-card-overlay">
                        <h3 class="team-card-name">{{ $member->name }}</h3>
                        <div class="team-card-role">{{ $member->designation }}</div>
                        <p style="font-size:0.75rem;color:var(--color-gray);" class="mb-3">{{ Str::limit($member->bio, 80) }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
