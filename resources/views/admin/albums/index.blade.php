@extends('layouts.admin')

@section('title', 'Photo Albums')
@section('page_title', 'Client Photo Albums Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-book-open mr-2"></i> All Albums</h3>
        <a href="{{ route('admin.albums.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Create New Album</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Album Title</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Featured</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($albums as $a)
                <tr>
                    <td><strong>{{ $a->title }}</strong></td>
                    <td>{{ $a->client_name ?? 'N/A' }}</td>
                    <td>{{ $a->service?->name ?? 'General' }}</td>
                    <td>{{ $a->event_date?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>{{ $a->location ?? 'N/A' }}</td>
                    <td>
                        @if($a->is_featured)
                        <span class="badge badge-success">Yes</span>
                        @else
                        <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary me-1" data-toggle="modal" data-target="#viewModal{{ $a->id }}"><i class="fas fa-eye"></i> View</button>
                        <a href="{{ route('admin.albums.edit', $a->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.albums.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this album?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>

                        <!-- View Album Modal -->
                        <div class="modal fade text-left" id="viewModal{{ $a->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-gold"><i class="fas fa-book-open mr-2"></i> {{ $a->title }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-5 mb-3">
                                                <img src="{{ $a->cover_image_url ?? 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800' }}" class="img-fluid rounded border border-secondary" alt="{{ $a->title }}">
                                            </div>
                                            <div class="col-md-7">
                                                <p class="mb-2"><strong>Client:</strong> {{ $a->client_name ?? 'N/A' }}</p>
                                                <p class="mb-2"><strong>Service Type:</strong> {{ $a->service?->name ?? 'General' }}</p>
                                                <p class="mb-2"><strong>Event Date:</strong> {{ $a->event_date?->format('M d, Y') ?? 'N/A' }}</p>
                                                <p class="mb-2"><strong>Location:</strong> {{ $a->location ?? 'N/A' }}</p>
                                                <p class="mb-2"><strong>Description:</strong></p>
                                                <p class="text-muted small">{{ $a->description ?? 'No detailed description.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ route('admin.albums.edit', $a->id) }}" class="btn btn-gold">Edit Album</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No albums created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $albums->links() }}
    </div>
</div>
@endsection
