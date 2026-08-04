@extends('layouts.admin')

@section('title', 'Add Instagram Post')
@section('page_title', 'Add New Instagram Post')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fab fa-instagram me-2"></i> Add New Instagram Post</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instagram-feeds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Upload Image File</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <small class="text-muted">Choose a photo from your computer (JPG, PNG, WEBP)</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Image URL</label>
                    <input type="text" name="media_url" class="form-control" value="{{ old('media_url') }}" placeholder="https://images.unsplash.com/... or image link">
                    <small class="text-muted">Direct image URL if you are referencing an external photo</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Instagram Post Permalink (Link)</label>
                    <input type="text" name="permalink" class="form-control" value="{{ old('permalink') }}" placeholder="https://www.instagram.com/p/Cxxx...">
                    <small class="text-muted">URL opened when visitor clicks this photo on your website</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                    <small class="text-muted">Lower numbers appear first (0, 1, 2...)</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Caption / Alt Description</label>
                    <textarea name="caption" class="form-control" rows="3" placeholder="Enter caption or description for this post">{{ old('caption') }}</textarea>
                </div>

                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label font-weight-bold" for="is_active">Show on Website Homepage</label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i> Save Instagram Post</button>
            <a href="{{ route('admin.instagram-feeds.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
