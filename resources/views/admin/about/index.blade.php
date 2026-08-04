@extends('layouts.admin')

@section('title', 'About Us & Brand Story Management')
@section('page_title', 'About Us & Brand Story Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-address-card mr-2"></i> About Us & Brand Story Settings</h3>
        <div>
            <button type="button" class="btn btn-info btn-sm me-1" data-toggle="modal" data-target="#livePreviewModal">
                <i class="fas fa-eye mr-1"></i> Live Card Preview
            </button>
            <a href="{{ route('home') }}#about" target="_blank" class="btn btn-gold btn-sm">
                <i class="fas fa-external-link-alt mr-1"></i> View On Website
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.about.update') }}" method="POST">
            @csrf
            
            <div class="row">
                <!-- Section Story Title & Text -->
                <div class="col-md-8 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-heading mr-2"></i> Heading & Story Intro</h5>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Section Main Heading Title *</label>
                        <textarea name="home_about_title" class="form-control" rows="2" required>{{ $about['home_about_title'] }}</textarea>
                        <small class="text-muted">Supports multiline text for clean line breaks.</small>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">About Paragraph Content *</label>
                        <textarea name="home_about_text" class="form-control" rows="4" required>{{ $about['home_about_text'] }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Brand Signature Name</label>
                        <input type="text" name="home_about_signature" class="form-control" value="{{ $about['home_about_signature'] }}">
                    </div>
                </div>

                <!-- Stats & Counters -->
                <div class="col-md-4 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-chart-line mr-2"></i> Experience & Counters</h5>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Years of Excellence Badge</label>
                        <input type="number" name="stat_experience" class="form-control" value="{{ $about['stat_experience'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Weddings Completed Counter</label>
                        <input type="number" name="stat_weddings" class="form-control" value="{{ $about['stat_weddings'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Happy Clients Counter</label>
                        <input type="number" name="stat_clients" class="form-control" value="{{ $about['stat_clients'] }}">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Awards Won Counter</label>
                        <input type="number" name="stat_awards" class="form-control" value="{{ $about['stat_awards'] }}">
                    </div>
                </div>

                <!-- Section Photos -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-images mr-2"></i> Section Photos</h5>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Main Banner Image URL</label>
                        <input type="text" name="home_about_image" class="form-control mb-2" value="{{ $about['home_about_image'] }}">
                        <img src="{{ $about['home_about_image'] }}" class="img-fluid rounded border border-secondary" style="max-height:150px;object-fit:cover;" alt="Main Image Preview">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold">Inset Accent Image URL</label>
                        <input type="text" name="home_about_accent" class="form-control mb-2" value="{{ $about['home_about_accent'] }}">
                        <img src="{{ $about['home_about_accent'] }}" class="img-fluid rounded border border-secondary" style="max-height:120px;object-fit:cover;" alt="Accent Image Preview">
                    </div>
                </div>

                <!-- Feature Check Bullet Points -->
                <div class="col-md-6 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-check-double mr-2"></i> Feature Highlights</h5>
                    <div class="form-group mb-2">
                        <label>Feature Highlight #1</label>
                        <input type="text" name="feature_1" class="form-control" value="{{ $about['feature_1'] }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Feature Highlight #2</label>
                        <input type="text" name="feature_2" class="form-control" value="{{ $about['feature_2'] }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Feature Highlight #3</label>
                        <input type="text" name="feature_3" class="form-control" value="{{ $about['feature_3'] }}">
                    </div>
                    <div class="form-group mb-2">
                        <label>Feature Highlight #4</label>
                        <input type="text" name="feature_4" class="form-control" value="{{ $about['feature_4'] }}">
                    </div>
                </div>

                <!-- Brand Mission, Vision & Core Values -->
                <div class="col-12 mb-4">
                    <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-compass mr-2"></i> Brand Mission, Vision & Core Values</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold">Our Mission Statement</label>
                            <textarea name="our_mission" class="form-control" rows="3">{{ $about['our_mission'] }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold">Our Vision Statement</label>
                            <textarea name="our_vision" class="form-control" rows="3">{{ $about['our_vision'] }}</textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label font-weight-bold">Core Brand Values</label>
                            <textarea name="our_values" class="form-control" rows="3">{{ $about['our_values'] }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-gold btn-lg"><i class="fas fa-save mr-2"></i> Save About Us & Brand Story Changes</button>
        </form>
    </div>
</div>

<!-- Live Preview Modal -->
<div class="modal fade" id="livePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-gold"><i class="fas fa-eye mr-2"></i> Live About Us Section Preview</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4 bg-black">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5">
                        <div class="position-relative">
                            <img src="{{ $about['home_about_image'] }}" class="img-fluid rounded shadow" style="width:100%;height:320px;object-fit:cover;" alt="Main">
                            <div class="position-absolute bg-warning text-dark p-3 rounded-circle text-center font-weight-bold" style="top:10px;left:10px;width:70px;height:70px;line-height:1.2;">
                                <span style="font-size:1.4rem;">{{ $about['stat_experience'] }}</span><br><small style="font-size:0.6rem;">YEARS</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <span class="text-gold font-weight-bold text-uppercase">ABOUT US</span>
                        <h3 class="text-white mt-1 mb-2">{!! nl2br(e($about['home_about_title'])) !!}</h3>
                        <p class="text-muted small mb-3">{{ $about['home_about_text'] }}</p>
                        <div class="row text-gold small mb-3">
                            <div class="col-6 mb-1"><i class="fas fa-check-circle mr-1"></i> {{ $about['feature_1'] }}</div>
                            <div class="col-6 mb-1"><i class="fas fa-check-circle mr-1"></i> {{ $about['feature_2'] }}</div>
                            <div class="col-6 mb-1"><i class="fas fa-check-circle mr-1"></i> {{ $about['feature_3'] }}</div>
                            <div class="col-6 mb-1"><i class="fas fa-check-circle mr-1"></i> {{ $about['feature_4'] }}</div>
                        </div>
                        <p class="text-warning font-italic font-weight-bold mb-0">— {{ $about['home_about_signature'] }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close Preview</button>
            </div>
        </div>
    </div>
</div>
@endsection
