@extends('layouts.admin')

@section('title', 'Edit Video Film')
@section('page_title', 'Edit Video Film')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Video: {{ $video->title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Video Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $video->title) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Platform Type</label>
                    <select name="video_type" class="form-control">
                        <option value="youtube" {{ $video->video_type === 'youtube' ? 'selected' : '' }}>YouTube</option>
                        <option value="vimeo" {{ $video->video_type === 'vimeo' ? 'selected' : '' }}>Vimeo</option>
                        <option value="custom" {{ $video->video_type === 'custom' ? 'selected' : '' }}>Direct MP4 URL</option>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Video Link / URL *</label>
                    <input type="url" name="video_url" class="form-control" value="{{ old('video_url', $video->video_url) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Associated Album</label>
                    <select name="album_id" class="form-control">
                        <option value="">Select Album (Optional)</option>
                        @foreach($albums as $a)
                        <option value="{{ $a->id }}" {{ $video->album_id == $a->id ? 'selected' : '' }}>{{ $a->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Duration</label>
                    <input type="text" name="duration" class="form-control" value="{{ old('duration', $video->duration) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $video->location) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Custom Thumbnail Image URL</label>
                    <input type="text" name="thumbnail" class="form-control" value="{{ old('thumbnail', $video->thumbnail) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ $video->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Featured Video</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $video->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Update Video</button>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
