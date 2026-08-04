@extends('layouts.admin')

@section('title', 'Hero Sliders')
@section('page_title', 'Homepage Hero Sliders Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-sliders-h mr-2"></i> Hero Sliders ({{ $sliders->count() }})</h3>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add New Slide</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Slide Title</th>
                    <th>Subtitle</th>
                    <th>Buttons</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $s)
                <tr>
                    <td width="100">
                        <img src="{{ $s->image_url }}" alt="{{ $s->title }}" style="width:80px;height:50px;object-fit:cover;border-radius:4px;">
                    </td>
                    <td><strong>{{ $s->title }}</strong></td>
                    <td><small class="text-muted">{{ $s->subtitle ?? 'N/A' }}</small></td>
                    <td>
                        <span class="badge badge-info me-1">{{ $s->button_text }}</span>
                        <span class="badge badge-secondary">{{ $s->button_text_2 }}</span>
                    </td>
                    <td>
                        @if($s->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.sliders.edit', $s->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.sliders.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this hero slide?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No hero slides found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
