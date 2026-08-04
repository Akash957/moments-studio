@extends('layouts.admin')

@section('title', isset($award) ? 'Edit Award' : 'Add Award')
@section('page_title', isset($award) ? 'Edit Award' : 'Add New Award')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-award mr-2"></i> {{ isset($award) ? 'Edit Award' : 'Create Award' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ isset($award) ? route('admin.awards.update', $award->id) : route('admin.awards.store') }}" method="POST">
            @csrf
            @if(isset($award)) @method('PUT') @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Award Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $award->title ?? '') }}" placeholder="e.g. Best International Wedding Photographer" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Year *</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', $award->year ?? date('Y')) }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Organization / Presenter</label>
                    <input type="text" name="organization" class="form-control" value="{{ old('organization', $award->organization ?? '') }}" placeholder="e.g. World Photography Awards">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Description / Citation</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $award->description ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Award Badge Image URL</label>
                    <input type="text" name="image" class="form-control" value="{{ old('image', $award->image ?? '') }}" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ (isset($award) && $award->is_featured) || !isset($award) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">Show on Homepage</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> {{ isset($award) ? 'Update Award' : 'Save Award' }}</button>
            <a href="{{ route('admin.awards.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
