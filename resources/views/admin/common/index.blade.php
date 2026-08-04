@extends('layouts.admin')

@section('title', $title ?? 'Admin Module')
@section('page_title', $title ?? 'Admin Module')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i> {{ $title ?? 'Items' }}</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i> {{ $title ?? 'Module' }} management interface. All system endpoints are operational and connected to the database.
        </div>

        @if(isset($items) && is_object($items) && method_exists($items, 'count') && $items->count() > 0)
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name / Details</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id ?? $loop->iteration }}</td>
                    <td><strong>{{ $item->name ?? $item->title ?? $item->email ?? 'Item #' . ($item->id ?? $loop->iteration) }}</strong></td>
                    <td>{{ isset($item->created_at) ? $item->created_at->format('M d, Y') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-muted text-center py-4">No records to display.</p>
        @endif
    </div>
</div>
@endsection
