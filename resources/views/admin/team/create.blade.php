@extends('layouts.admin')

@section('title', isset($member) ? 'Edit Team Member' : 'Add Team Member')
@section('page_title', isset($member) ? 'Edit Team Member' : 'Add Team Member')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i> {{ isset($member) ? 'Edit Member' : 'Add New Member' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ isset($member) ? route('admin.team.update', $member->id) : route('admin.team.store') }}" method="POST">
            @csrf
            @if(isset($member)) @method('PUT') @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $member->name ?? '') }}" placeholder="e.g. Vikram Malhotra" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation / Role *</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $member->designation ?? '') }}" placeholder="e.g. Lead Wedding Cinematographer" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Profile Image URL</label>
                    <input type="text" name="image" class="form-control" value="{{ old('image', $member->image ?? '') }}" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Short Bio</label>
                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $member->bio ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Instagram Handle / URL</label>
                    <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $member->instagram ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Facebook Profile URL</label>
                    <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $member->facebook ?? '') }}">
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> {{ isset($member) ? 'Update Member' : 'Save Member' }}</button>
            <a href="{{ route('admin.team.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
