@extends('layouts.admin')

@section('title', 'Add Video Film')
@section('page_title', 'Add Video Film')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Add Cinematic Video</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.videos.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Video Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Royal Wedding Teaser - Ananya & Vikram" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Platform Type</label>
                    <select name="video_type" class="form-control">
                        <option value="youtube">YouTube</option>
                        <option value="vimeo">Vimeo</option>
                        <option value="custom">Direct MP4 URL</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Video Link / URL *</label>
                    <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Associated Album</label>
                    <select name="album_id" class="form-control">
                        <option value="">Select Album (Optional)</option>
                        @foreach($albums as $a)
                        <option value="{{ $a->id }}">{{ $a->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g. 04:35">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="e.g. Udaipur">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Custom Thumbnail Image URL</label>
                    <input type="text" name="thumbnail" class="form-control" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
                        <label class="form-check-label" for="is_featured">Featured Video</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save Video</button>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
