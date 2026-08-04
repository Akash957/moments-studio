@extends('layouts.app')
@php $seoTitle = 'Search Results — Moments Studio'; @endphp

@section('content')
<section class="section section-dark pt-5">
    <div class="container" style="margin-top:100px;">
        <span class="section-label">Search Query</span>
        <h1 class="font-primary text-white mb-4">Results for "{{ $query }}"</h1>

        <div class="row g-4">
            @forelse($results as $res)
            <div class="col-md-6">
                <div class="contact-card p-4">
                    <span class="badge bg-gold text-black mb-2">{{ $res['type'] }}</span>
                    <h3 class="font-primary text-white mb-2" style="font-size:1.25rem;">
                        <a href="{{ $res['url'] }}" class="text-white hover-gold text-decoration-none">{{ $res['title'] }}</a>
                    </h3>
                    <a href="{{ $res['url'] }}" class="btn-arrow mt-2">
                        View Item <span class="arrow-circle"><i class="fas fa-arrow-right"></i></span>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-gray" style="font-size:1.25rem;">No results found for "{{ $query }}".</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
