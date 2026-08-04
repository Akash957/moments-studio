@extends('layouts.admin')

@section('title', 'Edit Testimonial')
@section('page_title', 'Edit Review')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Review: {{ $testimonial->client_name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.testimonials.update', $testimonial->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Client / Couple Name *</label>
                    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $testimonial->client_name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Wedding Location / City</label>
                    <input type="text" name="wedding_location" class="form-control" value="{{ old('wedding_location', $testimonial->wedding_location) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rating (1 to 5 Stars)</label>
                    <input type="number" step="0.5" min="1" max="5" name="rating" class="form-control" value="{{ old('rating', $testimonial->rating) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Review / Feedback *</label>
                    <textarea name="review" class="form-control" rows="4" required>{{ old('review', $testimonial->review) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ $testimonial->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Show on Homepage</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_approved" value="1" class="form-check-input" id="is_approved" {{ $testimonial->is_approved ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_approved">Approved</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Update Testimonial</button>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
