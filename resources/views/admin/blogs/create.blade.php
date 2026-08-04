@extends('layouts.admin')

@section('title', 'Write New Story')
@section('page_title', 'Create Blog Post')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Create Article</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.blogs.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Article Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. How to Choose Your Wedding Photographer" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Excerpt / Short Summary</label>
                    <textarea name="excerpt" class="form-control" rows="2" placeholder="Brief intro..."></textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Full Article Content (HTML/Text) *</label>
                    <textarea name="content" class="form-control" rows="8" required placeholder="Write your full story here..."></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Featured Image URL</label>
                    <input type="text" name="featured_image" class="form-control" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Reading Time (Minutes)</label>
                    <input type="number" name="reading_time" class="form-control" value="5">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-paper-plane mr-1"></i> Publish Article</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
