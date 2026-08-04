@extends('layouts.admin')

@section('title', 'SEO Meta Data Management')
@section('page_title', 'SEO & OpenGraph Configuration')

@section('content')
<div class="row">
    <!-- Left Navigation: Page Selector -->
    <div class="col-md-3">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i> Select Page</h3>
            </div>
            <div class="card-body p-0">
                <div class="nav flex-column nav-pills" role="tablist">
                    @foreach($pages as $slug => $label)
                    <a href="{{ route('admin.seo.index', ['page' => $slug]) }}" 
                       class="nav-link py-3 px-3 border-bottom {{ $selectedPage === $slug ? 'bg-gold text-dark font-weight-bold' : 'bg-dark text-white' }}"
                       style="transition: all 0.2s ease;">
                        <i class="fas fa-chevron-right mr-2 {{ $selectedPage === $slug ? 'text-dark' : 'text-warning' }}"></i> {{ $label }}
                        @if(isset($allMetas[$slug]))
                        <span class="badge {{ $selectedPage === $slug ? 'badge-dark' : 'badge-success' }} float-right">Configured</span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Right Content: Form for Selected Page -->
    <div class="col-md-9">
        <div class="card card-outline card-warning">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-search mr-2"></i> Editing SEO Settings for: <strong class="text-gold">{{ $pages[$selectedPage] ?? ucfirst($selectedPage) }}</strong></h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.seo.update', $selectedPage) }}" method="POST">
                    @csrf
                    
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-heading mr-2"></i> Search Engine Meta Tags</h5>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Meta Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $seo->title) }}" placeholder="Page title for Google search" required>
                            <small class="text-muted">Recommended length: 50-60 characters.</small>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief page summary for search engine results snippet...">{{ old('description', $seo->description) }}</textarea>
                            <small class="text-muted">Recommended length: 150-160 characters.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="keywords" class="form-control" value="{{ old('keywords', $seo->keywords) }}" placeholder="e.g. photography, wedding, candid, shoot">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Canonical URL</label>
                            <input type="url" name="canonical_url" class="form-control" value="{{ old('canonical_url', $seo->canonical_url) }}" placeholder="https://momentsstudio.in/...">
                        </div>
                    </div>

                    <h5 class="text-gold border-bottom pb-2 mb-3 mt-4"><i class="fab fa-facebook mr-2"></i> Social Media OpenGraph (Facebook / WhatsApp / LinkedIn)</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">OG Title</label>
                            <input type="text" name="og_title" class="form-control" value="{{ old('og_title', $seo->og_title) }}" placeholder="Social share title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">OG Featured Image URL</label>
                            <input type="text" name="og_image" class="form-control" value="{{ old('og_image', $seo->og_image) }}" placeholder="https://images.unsplash.com/...">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">OG Description</label>
                            <textarea name="og_description" class="form-control" rows="2" placeholder="Description when link is shared on social media...">{{ old('og_description', $seo->og_description) }}</textarea>
                        </div>
                    </div>

                    <h5 class="text-gold border-bottom pb-2 mb-3 mt-4"><i class="fab fa-twitter mr-2"></i> Twitter Card Meta Tags</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter Card Title</label>
                            <input type="text" name="twitter_title" class="form-control" value="{{ old('twitter_title', $seo->twitter_title) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter Image URL</label>
                            <input type="text" name="twitter_image" class="form-control" value="{{ old('twitter_image', $seo->twitter_image) }}">
                        </div>
                    </div>

                    <h5 class="text-gold border-bottom pb-2 mb-3 mt-4"><i class="fas fa-code mr-2"></i> Custom Head Scripts & Schema JSON-LD</h5>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Custom Head Scripts (Google Analytics / Pixel)</label>
                            <textarea name="head_scripts" class="form-control font-monospace" rows="3" placeholder="<script>...</script>">{{ old('head_scripts', $seo->head_scripts) }}</textarea>
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-gold btn-lg"><i class="fas fa-save mr-2"></i> Save SEO Settings for {{ $pages[$selectedPage] ?? $selectedPage }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
