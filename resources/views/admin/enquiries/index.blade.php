@extends('layouts.admin')

@section('title', 'Enquiries & Messages')
@section('page_title', 'Contact Enquiries')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-envelope mr-2"></i> Client Enquiries ({{ $enquiries->total() }})</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Subject / Event</th>
                    <th>Status</th>
                    <th>Received At</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enquiries as $e)
                <tr>
                    <td><strong>{{ $e->name }}</strong></td>
                    <td><a href="mailto:{{ $e->email }}">{{ $e->email }}</a></td>
                    <td><a href="tel:{{ $e->phone }}">{{ $e->phone }}</a></td>
                    <td>{{ $e->subject ?? ucfirst($e->event_type ?? 'General') }}</td>
                    <td>
                        @if($e->status === 'new')
                        <span class="badge badge-warning">New</span>
                        @elseif($e->status === 'read')
                        <span class="badge badge-info">Read</span>
                        @else
                        <span class="badge badge-success">Replied</span>
                        @endif
                    </td>
                    <td>{{ $e->created_at->diffForHumans() }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.enquiries.show', $e->id) }}" class="btn btn-sm btn-primary me-1"><i class="fas fa-eye"></i> View</a>
                        <form action="{{ route('admin.enquiries.destroy', $e->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this enquiry?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No enquiries received yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $enquiries->links() }}
    </div>
</div>
@endsection
