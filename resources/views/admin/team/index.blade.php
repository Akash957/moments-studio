@extends('layouts.admin')

@section('title', 'Our Team')
@section('page_title', 'Studio Photographers & Crew')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-users mr-2"></i> Team Members ({{ $team->total() }})</h3>
        <a href="{{ route('admin.team.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add Team Member</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($team as $m)
                <tr>
                    <td width="80">
                        <img src="{{ $m->image_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200' }}" alt="{{ $m->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:50%;">
                    </td>
                    <td><strong>{{ $m->name }}</strong></td>
                    <td>{{ $m->designation }}</td>
                    <td>
                        @if($m->is_active ?? true)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.team.edit', $m->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.team.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this team member?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No team members added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
