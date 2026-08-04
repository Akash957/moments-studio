@extends('layouts.admin')

@section('title', 'Instagram Feed Management')
@section('page_title', 'Instagram Feed & Header Settings')

@section('content')

{{-- ====================================================
     INSTAGRAM SECTION SETTINGS
     ==================================================== --}}
<div class="card card-outline card-warning mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fab fa-instagram me-2 text-danger"></i> Instagram Section Header Settings</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.instagram-feeds.settings') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label font-weight-bold">Section Label</label>
                    <input type="text" name="instagram_section_label" class="form-control" value="{{ old('instagram_section_label', $settings['instagram_section_label']) }}" placeholder="Instagram" required>
                    <small class="text-muted">Sub-heading above title</small>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label font-weight-bold">Section Main Title</label>
                    <input type="text" name="instagram_section_title" class="form-control" value="{{ old('instagram_section_title', $settings['instagram_section_title']) }}" placeholder="Follow Our Journey" required>
                    <small class="text-muted">Main heading on homepage</small>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label font-weight-bold">Instagram Username / Handle</label>
                    <input type="text" name="site_instagram" class="form-control" value="{{ old('site_instagram', $settings['site_instagram']) }}" placeholder="@momentsstudio" required>
                    <small class="text-muted">Displayed under section title</small>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label font-weight-bold">Instagram Profile Link URL</label>
                    <input type="url" name="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/yourhandle" required>
                    <small class="text-muted">Link where visitors go on click</small>
                </div>
            </div>
            <button type="submit" class="btn btn-warning text-dark"><i class="fas fa-save me-1"></i> Save Section Settings</button>
        </form>
    </div>
</div>

{{-- ====================================================
     INSTAGRAM POSTS TABLE
     ==================================================== --}}
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-images me-2"></i> Instagram Posts / Feed Items</h3>
        <a href="{{ route('admin.instagram-feeds.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus me-1"></i> Add New Instagram Post</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">Preview</th>
                    <th>Caption / Title</th>
                    <th>Post Link</th>
                    <th>Sort Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feeds as $feed)
                <tr>
                    <td>
                        <img src="{{ $feed->media_url }}" alt="Instagram Image" class="rounded shadow-sm" style="width: 55px; height: 55px; object-fit: cover;">
                    </td>
                    <td>
                        <strong>{{ Str::limit($feed->caption ?? 'Instagram Post', 50) }}</strong>
                    </td>
                    <td>
                        @if($feed->permalink)
                        <a href="{{ $feed->permalink }}" target="_blank" class="text-info text-decoration-none">
                            <i class="fas fa-external-link-alt me-1"></i> View Link
                        </a>
                        @else
                        <span class="text-muted">Default Profile</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-secondary text-white">{{ $feed->sort_order }}</span>
                    </td>
                    <td>
                        @if($feed->is_active)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.instagram-feeds.edit', $feed->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.instagram-feeds.destroy', $feed->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this Instagram post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">
                        <i class="fab fa-instagram fa-2x mb-2 display-block"></i><br>
                        No Instagram posts added yet. Click "Add New Instagram Post" to add photos!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($feeds->hasPages())
    <div class="card-footer clearfix">
        {{ $feeds->links() }}
    </div>
    @endif
</div>
@endsection
