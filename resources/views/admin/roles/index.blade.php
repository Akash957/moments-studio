@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('page_title', 'Access Control & User Roles')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-user-lock mr-2"></i> User Roles & Access Rights</h3>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Create New Role</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th>Guard</th>
                    <th>Assigned Permissions</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $r)
                <tr>
                    <td>
                        <strong class="text-gold">{{ ucfirst($r->name) }}</strong>
                    </td>
                    <td><span class="badge badge-info">{{ $r->guard_name }}</span></td>
                    <td>
                        @forelse($r->permissions as $p)
                        <span class="badge badge-secondary mb-1 me-1">{{ $p->name }}</span>
                        @empty
                        <span class="badge badge-warning">Full Admin Access (All)</span>
                        @endforelse
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.roles.edit', $r->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        @if(!in_array($r->name, ['Super Admin', 'Admin', 'super-admin', 'admin']))
                        <form action="{{ route('admin.roles.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No roles defined yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
