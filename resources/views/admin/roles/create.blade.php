@extends('layouts.admin')

@section('title', 'Create New Role')
@section('page_title', 'Add Access Role')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Create New Role & Assign Permissions</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label class="form-label font-weight-bold">Role Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Editor, Photographer, Booking Manager" required>
                </div>
            </div>

            <h5 class="text-gold border-bottom pb-2 mb-3"><i class="fas fa-key mr-2"></i> Select Group Permissions</h5>
            <div class="row">
                @foreach($permissions as $group => $perms)
                <div class="col-md-6 mb-4">
                    <div class="card bg-dark text-white border-secondary">
                        <div class="card-header border-secondary bg-black">
                            <h6 class="mb-0 text-gold font-weight-bold"><i class="fas fa-layer-group mr-2"></i> {{ $group }}</h6>
                        </div>
                        <div class="card-body">
                            @foreach($perms as $p)
                            <div class="form-check mb-2">
                                <input type="checkbox" name="permissions[]" value="{{ $p }}" class="form-check-input" id="perm_{{ $p }}" checked>
                                <label class="form-check-label" for="perm_{{ $p }}">{{ ucwords(str_replace('_', ' ', $p)) }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save Role</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
