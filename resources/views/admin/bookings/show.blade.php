@extends('layouts.admin')

@section('title', 'Booking Details #' . $booking->booking_number)
@section('page_title', 'Booking #' . $booking->booking_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i> Client & Event Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Booking Number</th>
                        <td><strong class="text-gold">{{ $booking->booking_number }}</strong></td>
                    </tr>
                    <tr>
                        <th>Client Name</th>
                        <td>{{ $booking->client_name }}</td>
                    </tr>
                    <tr>
                        <th>Client Email</th>
                        <td><a href="mailto:{{ $booking->client_email }}">{{ $booking->client_email }}</a></td>
                    </tr>
                    <tr>
                        <th>Client Phone</th>
                        <td><a href="tel:{{ $booking->client_phone }}">{{ $booking->client_phone }}</a></td>
                    </tr>
                    <tr>
                        <th>Event Type</th>
                        <td><span class="badge badge-info">{{ ucfirst($booking->event_type) }}</span></td>
                    </tr>
                    <tr>
                        <th>Event Date</th>
                        <td>{{ $booking->event_date?->format('F d, Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Location / Venue</th>
                        <td>{{ $booking->event_location ?? 'Not specified' }}</td>
                    </tr>
                    <tr>
                        <th>Special Requirements</th>
                        <td>{{ $booking->special_requirements ?? 'None' }}</td>
                    </tr>
                    <tr>
                        <th>Booking Status</th>
                        <td>
                            @if($booking->status === 'confirmed')
                            <span class="badge badge-success fs-6">Confirmed</span>
                            @elseif($booking->status === 'pending')
                            <span class="badge badge-warning fs-6">Pending</span>
                            @else
                            <span class="badge badge-secondary fs-6">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Back to Bookings</a>
            </div>
        </div>
    </div>
</div>
@endsection
