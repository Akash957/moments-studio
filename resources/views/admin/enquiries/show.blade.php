@extends('layouts.admin')

@section('title', 'Enquiry Message')
@section('page_title', 'View Enquiry from ' . $enquiry->name)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-envelope-open-text mr-2"></i> Message Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Sender Name</th>
                        <td><strong>{{ $enquiry->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Email Address</th>
                        <td><a href="mailto:{{ $enquiry->email }}">{{ $enquiry->email }}</a></td>
                    </tr>
                    <tr>
                        <th>Phone Number</th>
                        <td><a href="tel:{{ $enquiry->phone }}">{{ $enquiry->phone }}</a></td>
                    </tr>
                    <tr>
                        <th>Subject / Event</th>
                        <td>{{ $enquiry->subject ?? ucfirst($enquiry->event_type ?? 'General') }}</td>
                    </tr>
                    <tr>
                        <th>Received Time</th>
                        <td>{{ $enquiry->created_at->format('F d, Y h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Message Content</th>
                        <td style="white-space: pre-line; background: #222; color: #fff; padding: 1rem; border-radius: 8px;">{{ $enquiry->message }}</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="mailto:{{ $enquiry->email }}" class="btn btn-gold me-2"><i class="fas fa-reply mr-1"></i> Reply via Email</a>
                <a href="{{ route('admin.enquiries.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i> Back to Enquiries</a>
            </div>
        </div>
    </div>
</div>
@endsection
