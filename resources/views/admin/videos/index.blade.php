@extends('layouts.admin')

@section('title', 'Cinematic Videos')
@section('page_title', 'Cinematic Films & Teasers')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-video mr-2"></i> All Videos ({{ $videos->total() }})</h3>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add Video Film</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Platform</th>
                    <th>Album</th>
                    <th>Duration</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videos as $v)
                <tr>
                    <td><strong>{{ $v->title }}</strong><br><small class="text-muted"><a href="{{ $v->video_url }}" target="_blank">{{ $v->video_url }}</a></small></td>
                    <td><span class="badge badge-info">{{ strtoupper($v->video_type ?? 'YouTube') }}</span></td>
                    <td>{{ $v->album?->title ?? 'General' }}</td>
                    <td>{{ $v->duration ?? 'N/A' }}</td>
                    <td>
                        @if($v->is_featured)
                        <span class="badge badge-success">Yes</span>
                        @else
                        <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        @if($v->is_active ?? true)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.videos.edit', $v->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.videos.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this video film?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No video films added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $videos->links() }}
    </div>
</div>
@endsection
