@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')
@section('page_title', 'Email Newsletter Subscribers')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-envelope-open mr-2"></i> Active Subscribers ({{ $subs->total() }})</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Subscribed At</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subs as $s)
                <tr>
                    <td><strong>{{ $s->email }}</strong></td>
                    <td>{{ $s->created_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                    <td class="text-right">
                        <form action="{{ route('admin.newsletter.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove subscriber?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Unsubscribe</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4">No subscribers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $subs->links() }}
    </div>
</div>
@endsection
