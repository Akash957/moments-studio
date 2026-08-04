@extends('layouts.app')
@php $seoTitle = 'Frequently Asked Questions — Moments Studio'; @endphp
@section('content')
<section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=1920');">
    <div class="container text-center page-hero-content">
        <span class="section-label">Help Center</span>
        <h1 class="page-hero-title">Frequently Asked Questions</h1>
    </div>
</section>
<section class="section section-dark">
    <div class="container" style="max-width:800px;">
        @foreach($categories as $category)
        <div class="mb-5" data-aos="fade-up">
            <h3 class="font-primary text-gold mb-4" style="font-size:1.5rem;"><i class="{{ $category->icon ?? 'fas fa-question-circle' }} me-2"></i>{{ $category->name }}</h3>
            <div class="accordion" id="faqAcc{{ $category->id }}">
                @foreach($category->faqs as $index => $faq)
                <div class="mb-3" style="background:var(--color-dark-2);border-radius:var(--radius-lg);border:1px solid rgba(201,169,110,0.15);overflow:hidden;">
                    <button class="w-100 text-start p-3 font-primary text-white d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}" style="background:none;border:none;font-size:1.0625rem;cursor:pointer;">
                        <span>{{ $faq->question }}</span>
                        <i class="fas fa-chevron-down text-gold" style="font-size:0.875rem;"></i>
                    </button>
                    <div id="collapse{{ $faq->id }}" class="p-3 pt-0" style="color:var(--color-gray);font-size:0.875rem;line-height:1.7;">
                        {{ $faq->answer }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection
