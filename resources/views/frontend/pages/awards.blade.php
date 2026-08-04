@extends('layouts.app')
@php $seoTitle = 'Awards & Recognition — Moments Studio'; @endphp
@section('content')
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?w=1920');">
    <div class="container text-center page-hero-content">
        <span class="section-label">Honors</span>
        <h1 class="page-hero-title">Awards & Recognition</h1>
    </div>
</section>
<section class="section section-dark">
    <div class="container">
        <div class="awards-grid">
            @foreach($awards as $award)
            <div class="award-card" data-aos="fade-up">
                <div class="award-icon"><i class="fas fa-trophy"></i></div>
                <div>
                    <div class="award-title">{{ $award->title }}</div>
                    <div class="award-org">{{ $award->organization }}</div>
                    <div class="award-year">{{ $award->year }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
