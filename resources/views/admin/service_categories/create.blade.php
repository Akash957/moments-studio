@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Service Category' : 'Add Service Category')
@section('page_title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-tags mr-2"></i> {{ isset($category) ? 'Edit Category' : 'Create New Category' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ isset($category) ? route('admin.service-categories.update', $category->id) : route('admin.service-categories.store') }}" method="POST">
            @csrf
            @if(isset($category)) @method('PUT') @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Pre-Wedding, Corporate Shoot" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">FontAwesome Icon Class</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $category->icon ?? 'fas fa-heart') }}" placeholder="e.g. fas fa-heart, fas fa-ring">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Category Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category Cover Image URL</label>
                    <input type="text" name="image" class="form-control" value="{{ old('image', $category->image ?? '') }}" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ (isset($category) && $category->is_active) || !isset($category) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active Category</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> {{ isset($category) ? 'Update Category' : 'Save Category' }}</button>
            <a href="{{ route('admin.service-categories.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
