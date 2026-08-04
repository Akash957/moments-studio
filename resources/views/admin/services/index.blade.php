@extends('layouts.admin')

@section('title', 'Services Management')
@section('page_title', 'Studio Photography Services')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-camera mr-2"></i> All Services</h3>
        <a href="{{ route('admin.services.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add New Service</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Starting Price</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $s)
                <tr>
                    <td>{{ $s->id }}</td>
                    <td><i class="{{ $s->icon ?? 'fas fa-camera' }} text-gold fa-lg"></i></td>
                    <td><strong>{{ $s->name }}</strong></td>
                    <td><span class="badge badge-warning bg-warning text-dark">{{ $s->category?->name ?? 'General' }}</span></td>
                    <td><strong class="text-gold">₹{{ number_format($s->starting_price, 0) }}</strong></td>
                    <td>
                        @if($s->is_featured)
                        <span class="badge badge-success">Yes</span>
                        @else
                        <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        @if($s->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary me-1" data-toggle="modal" data-target="#viewModal{{ $s->id }}"><i class="fas fa-eye"></i> View</button>
                        <a href="{{ route('admin.services.edit', $s->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.services.destroy', $s->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>

                        <!-- View Service Modal -->
                        <div class="modal fade text-left" id="viewModal{{ $s->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-gold"><i class="{{ $s->icon ?? 'fas fa-camera' }} mr-2"></i> {{ $s->name }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Starting Price:</strong> ₹{{ number_format($s->starting_price, 0) }}</p>
                                        <p><strong>Short Description:</strong></p>
                                        <p class="text-muted">{{ $s->short_description ?? 'N/A' }}</p>
                                        <p><strong>Full Description:</strong></p>
                                        <div class="bg-black p-3 rounded border border-secondary">{{ $s->description ?? 'No full description.' }}</div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ route('admin.services.edit', $s->id) }}" class="btn btn-gold">Edit Service</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No services found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $services->links() }}
    </div>
</div>
@endsection
