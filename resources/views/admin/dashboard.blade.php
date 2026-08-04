@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Studio Overview Dashboard')

@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total_bookings'] }}</h3>
                <p>Total Bookings ({{ $stats['pending_bookings'] }} Pending)</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-check"></i>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">View Bookings <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['total_enquiries'] }}</h3>
                <p>Enquiries ({{ $stats['new_enquiries'] }} New)</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
            <a href="{{ route('admin.enquiries.index') }}" class="small-box-footer">View Enquiries <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_photos'] }}</h3>
                <p>Gallery Photos</p>
            </div>
            <div class="icon">
                <i class="fas fa-images"></i>
            </div>
            <a href="{{ route('admin.gallery.index') }}" class="small-box-footer">Manage Portfolio <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['total_blogs'] }}</h3>
                <p>Published Stories</p>
            </div>
            <div class="icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="small-box-footer">Manage Blog <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7">
        <!-- Recent Bookings Card -->
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt mr-2 text-warning"></i> Recent Reservation Requests</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Booking #</th>
                            <th>Client</th>
                            <th>Event</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                        <tr>
                            <td><strong>{{ $b->booking_number }}</strong></td>
                            <td>{{ $b->client_name }}</td>
                            <td><span class="badge badge-info">{{ ucfirst($b->event_type) }}</span></td>
                            <td>{{ $b->event_date?->format('M d, Y') }}</td>
                            <td>
                                @if($b->status === 'confirmed')
                                <span class="badge badge-success">Confirmed</span>
                                @elseif($b->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                                @else
                                <span class="badge badge-secondary">{{ ucfirst($b->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">No recent bookings.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Right col -->
    <section class="col-lg-5">
        <!-- Recent Enquiries Card -->
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-envelope-open-text mr-2 text-info"></i> Latest Contact Messages</h3>
            </div>
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    @forelse($recentEnquiries as $e)
                    <li class="item">
                        <div class="product-info ml-2">
                            <a href="{{ route('admin.enquiries.show', $e->id) }}" class="product-title">
                                {{ $e->name }}
                                <span class="badge badge-warning float-right">{{ $e->created_at->diffForHumans() }}</span>
                            </a>
                            <span class="product-description text-muted">
                                {{ Str::limit($e->message, 70) }}
                            </span>
                        </div>
                    </li>
                    @empty
                    <li class="item p-3 text-center text-muted">No messages received yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
</div>

@endsection
