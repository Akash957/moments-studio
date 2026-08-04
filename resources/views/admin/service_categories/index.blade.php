@extends('layouts.admin')

@section('title', 'Service Categories')
@section('page_title', 'Service Categories Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-tags mr-2"></i> All Service Categories ({{ $categories->total() }})</h3>
        <a href="{{ route('admin.service-categories.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add Category</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Linked Services</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td><i class="{{ $cat->icon ?? 'fas fa-camera' }} text-gold fa-lg"></i></td>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td><span class="badge badge-info">{{ $cat->services_count }} Services</span></td>
                    <td>
                        @if($cat->is_active ?? true)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.service-categories.edit', $cat->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.service-categories.destroy', $cat->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No service categories created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $categories->links() }}
    </div>
</div>
@endsection
