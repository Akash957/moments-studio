@extends('layouts.admin')

@section('title', 'Edit Instagram Post')
@section('page_title', 'Edit Instagram Post')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fab fa-instagram me-2"></i> Edit Instagram Post</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instagram-feeds.update', $feed->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label font-weight-bold">Current Image Preview</label>
                    <div>
                        <img src="{{ $feed->media_url }}" alt="Instagram Image" class="rounded shadow-sm border" style="max-height: 150px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Replace Image File</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <small class="text-muted">Upload new photo to replace current image</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Image URL</label>
                    <input type="text" name="media_url" class="form-control" value="{{ old('media_url', $feed->media_url) }}" placeholder="https://images.unsplash.com/...">
                    <small class="text-muted">Image URL link</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Instagram Post Permalink (Link)</label>
                    <input type="text" name="permalink" class="form-control" value="{{ old('permalink', $feed->permalink) }}" placeholder="https://www.instagram.com/p/Cxxx...">
                    <small class="text-muted">URL opened when visitor clicks this photo</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $feed->sort_order) }}">
                    <small class="text-muted">Lower numbers appear first</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Caption / Alt Description</label>
                    <textarea name="caption" class="form-control" rows="3">{{ old('caption', $feed->caption) }}</textarea>
                </div>

                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $feed->is_active ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_active">Show on Website Homepage</label>
                    </div>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i> Update Instagram Post</button>
            <a href="{{ route('admin.instagram-feeds.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
