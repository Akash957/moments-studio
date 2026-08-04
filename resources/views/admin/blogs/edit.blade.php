@extends('layouts.admin')

@section('title', 'Edit Article')
@section('page_title', 'Edit Story')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Article: {{ $blog->title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Article Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $blog->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Excerpt / Short Summary</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog->excerpt) }}</textarea>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Full Article Content (HTML/Text) *</label>
                    <textarea name="content" class="form-control" rows="8" required>{{ old('content', $blog->content) }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Featured Image URL</label>
                    <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $blog->featured_image) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Reading Time (Minutes)</label>
                    <input type="number" name="reading_time" class="form-control" value="{{ old('reading_time', $blog->reading_time) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="published" {{ $blog->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $blog->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Update Article</button>
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
