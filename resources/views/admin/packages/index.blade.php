@extends('layouts.admin')

@section('title', 'Packages & Pricing')
@section('page_title', 'Studio Pricing Packages')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-box mr-2"></i> All Packages</h3>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add New Package</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Price (₹)</th>
                    <th>Badge</th>
                    <th>Hours</th>
                    <th>Photos</th>
                    <th>Photographers</th>
                    <th>Popular</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $p)
                <tr>
                    <td><strong>{{ $p->name }}</strong><br><small class="text-muted">{{ $p->tagline }}</small></td>
                    <td><strong class="text-gold">₹{{ number_format($p->price, 0) }}</strong></td>
                    <td>
                        @if($p->badge)
                        <span class="badge badge-warning">{{ $p->badge }}</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $p->hours }} Hours</td>
                    <td>{{ $p->edited_photos }}+</td>
                    <td>{{ $p->photographers }}</td>
                    <td>
                        @if($p->is_popular)
                        <span class="badge badge-success">Yes</span>
                        @else
                        <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td>
                        @if($p->is_active)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary me-1" data-toggle="modal" data-target="#viewModal{{ $p->id }}"><i class="fas fa-eye"></i> View</button>
                        <a href="{{ route('admin.packages.edit', $p->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.packages.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this package?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>

                        <!-- View Package Modal -->
                        <div class="modal fade text-left" id="viewModal{{ $p->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-gold"><i class="fas fa-box mr-2"></i> {{ $p->name }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-2"><strong>Price:</strong> ₹{{ number_format($p->price, 0) }}</p>
                                        <p class="mb-2"><strong>Coverage:</strong> {{ $p->hours }} Hours</p>
                                        <p class="mb-2"><strong>Photographers:</strong> {{ $p->photographers }}</p>
                                        <p class="mb-2"><strong>Edited Photos:</strong> {{ $p->edited_photos }}+</p>
                                        <p class="mb-2"><strong>Included Features:</strong></p>
                                        <ul class="text-muted pl-3">
                                            @if(is_array($p->features))
                                                @foreach($p->features as $f)
                                                    <li>{{ $f }}</li>
                                                @endforeach
                                            @else
                                                <li>{{ $p->description ?? 'Standard package features included.' }}</li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ route('admin.packages.edit', $p->id) }}" class="btn btn-gold">Edit Package</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">No packages created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
