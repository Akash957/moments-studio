@extends('layouts.admin')

@section('title', isset($user) ? 'Edit Admin User' : 'Add Admin User')
@section('page_title', isset($user) ? 'Edit Admin User' : 'Add Admin User')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-user-shield mr-2"></i> {{ isset($user) ? 'Edit Admin Credentials' : 'Create New Admin' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
            @csrf
            @if(isset($user)) @method('PUT') @endif
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" placeholder="e.g. Admin Manager" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" placeholder="admin@momentsstudio.in" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password {{ isset($user) ? '(Leave blank to keep unchanged)' : '*' }}</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" {{ isset($user) ? '' : 'required' }}>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> {{ isset($user) ? 'Update Admin' : 'Save Admin' }}</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
