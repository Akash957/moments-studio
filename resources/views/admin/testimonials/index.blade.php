@extends('layouts.admin')

@section('title', 'Client Testimonials')
@section('page_title', 'Client Reviews & Testimonials')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-star mr-2"></i> All Testimonials</h3>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add Testimonial</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Review Snippet</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                <tr>
                    <td><strong>{{ $t->client_name }}</strong></td>
                    <td>{{ $t->wedding_location ?? 'N/A' }}</td>
                    <td><span class="text-warning"><i class="fas fa-star"></i> {{ number_format($t->rating, 1) }}</span></td>
                    <td><small class="text-muted">{{ Str::limit($t->review, 60) }}</small></td>
                    <td>
                        @if($t->is_approved)
                        <span class="badge badge-success">Approved</span>
                        @else
                        <span class="badge badge-warning">Pending Approval</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if(!$t->is_approved)
                        <form action="{{ route('admin.testimonials.approve', $t->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success me-1"><i class="fas fa-check"></i> Approve</button>
                        </form>
                        @endif
                        <a href="{{ route('admin.testimonials.edit', $t->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No client reviews added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
