@extends('layouts.admin')

@section('title', 'Add New Photo')
@section('page_title', 'Add Photo to Portfolio')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Add Photo to Gallery</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.gallery.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Photo Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Royal Wedding Reception" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Image URL / File Path *</label>
                    <input type="text" name="image" class="form-control" placeholder="https://images.unsplash.com/... or storage path" required>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
                        <label class="form-check-label" for="is_featured">Show on Homepage Featured Gallery</label>
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
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save to Gallery</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
