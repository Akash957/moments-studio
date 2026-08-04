@extends('layouts.admin')

@section('title', 'Gallery Portfolio')
@section('page_title', 'Portfolio Gallery Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-images mr-2"></i> Gallery Items ({{ $galleries->total() }})</h3>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-upload mr-1"></i> Add New Photo</a>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @forelse($galleries as $g)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 bg-dark text-white border-secondary shadow-sm">
                    <img src="{{ $g->image_url }}" class="card-img-top" alt="{{ $g->title }}" style="height:200px;object-fit:cover;">
                    <div class="card-body p-3">
                        <h6 class="card-title text-gold text-truncate w-100 mb-1">{{ $g->title }}</h6>
                        <p class="card-text small text-muted mb-2">Category: {{ $g->category?->name ?? 'General' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($g->is_featured)
                                <span class="badge badge-warning me-1">Featured</span>
                                @endif
                                @if($g->is_active)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary me-1" data-toggle="modal" data-target="#viewModal{{ $g->id }}"><i class="fas fa-eye"></i></button>
                                <a href="{{ route('admin.gallery.edit', $g->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.gallery.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this image?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View Gallery Photo Modal -->
                <div class="modal fade text-left" id="viewModal{{ $g->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header border-secondary">
                                <h5 class="modal-title text-gold"><i class="fas fa-image mr-2"></i> {{ $g->title }}</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ $g->image_url }}" alt="{{ $g->title }}" class="img-fluid rounded mb-3" style="max-height:450px;">
                                <p class="mb-1"><strong>Category:</strong> {{ $g->category?->name ?? 'General' }}</p>
                                <p class="mb-1"><strong>Direct URL:</strong> <a href="{{ $g->image_url }}" target="_blank" class="text-gold">{{ $g->image_url }}</a></p>
                            </div>
                            <div class="modal-footer border-secondary">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <a href="{{ route('admin.gallery.edit', $g->id) }}" class="btn btn-gold">Edit Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">No gallery images uploaded yet.</p>
                <a href="{{ route('admin.gallery.create') }}" class="btn btn-gold"><i class="fas fa-plus mr-1"></i> Add First Photo</a>
            </div>
            @endforelse
        </div>
    </div>
    <div class="card-footer">
        {{ $galleries->links() }}
    </div>
</div>
@endsection
