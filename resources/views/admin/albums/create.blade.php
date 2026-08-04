@extends('layouts.admin')

@section('title', 'Create Album')
@section('page_title', 'Create Client Album')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Create Photo Album</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.albums.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Album Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Royal Udaipur Wedding - Ananya & Vikram" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Client Name</label>
                    <input type="text" name="client_name" class="form-control" placeholder="e.g. Ananya & Vikram">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Service</label>
                    <select name="service_id" class="form-control">
                        <option value="">Select Service</option>
                        @foreach($services as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Event Location</label>
                    <input type="text" name="location" class="form-control" placeholder="e.g. Udaipur, Rajasthan">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cover Image URL</label>
                    <input type="text" name="cover_image" class="form-control" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Story behind this shoot..."></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
                        <label class="form-check-label" for="is_featured">Featured Album</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" checked>
                        <label class="form-check-label" for="is_published">Published</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save Album</button>
            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
