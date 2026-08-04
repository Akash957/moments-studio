@extends('layouts.admin')

@section('title', 'Bookings & Reservations')
@section('page_title', 'Client Bookings Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-calendar-check mr-2"></i> All Bookings ({{ $bookings->total() }})</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Client Name</th>
                    <th>Email / Phone</th>
                    <th>Event Type</th>
                    <th>Event Date</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td><strong>{{ $b->booking_number }}</strong></td>
                    <td>{{ $b->client_name }}</td>
                    <td>
                        {{ $b->client_email }}<br>
                        <small class="text-muted">{{ $b->client_phone }}</small>
                    </td>
                    <td><span class="badge badge-info">{{ ucfirst($b->event_type) }}</span></td>
                    <td>{{ $b->event_date?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.bookings.status', $b->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <select name="status" class="form-control form-control-sm d-inline-block w-auto" onchange="this.form.submit()">
                                <option value="pending" {{ $b->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $b->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $b->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $b->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-sm btn-primary me-1"><i class="fas fa-eye"></i> View</a>
                        <form action="{{ route('admin.bookings.destroy', $b->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No bookings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
