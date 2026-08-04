@extends('layouts.admin')

@section('title', 'Admin Users')
@section('page_title', 'System Administrators & Managers')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-users-cog mr-2"></i> System Users ({{ $users->total() }})</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-user-plus mr-1"></i> Add New Admin</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Created At</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>
                        <strong>{{ $u->name }}</strong>
                        @if($u->id === auth()->id())
                        <span class="badge badge-warning ms-1">You</span>
                        @endif
                    </td>
                    <td><a href="mailto:{{ $u->email }}">{{ $u->email }}</a></td>
                    <td>{{ $u->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        @if($u->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this admin user?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No admin users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection
