@extends('layouts.admin')

@section('title', 'Edit Service')
@section('page_title', 'Edit Service: ' . $service->name)

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit me-2"></i> Edit Service</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Service Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Service Category</label>
                    <select name="category_id" class="form-control form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Icon Class (FontAwesome)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label font-weight-bold">Current Featured Cover Image</label>
                    <div>
                        <img src="{{ $service->featured_image_url }}" alt="Service Image" class="rounded shadow-sm border mb-2" style="max-height: 150px; object-fit: cover;">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Replace Featured Image File</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <small class="text-muted">Upload new photo from computer</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Image URL</label>
                    <input type="text" name="featured_image" class="form-control" value="{{ old('featured_image', $service->featured_image) }}" placeholder="https://images.unsplash.com/...">
                    <small class="text-muted">Direct image URL</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Starting Price (₹) *</label>
                    <input type="number" name="starting_price" class="form-control" value="{{ old('starting_price', $service->starting_price) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Tagline / Subheading</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $service->tagline) }}">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Short Summary Description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description', $service->short_description) }}</textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Full Detailed Description</label>
                    <textarea name="long_description" class="form-control" rows="5">{{ old('long_description', $service->long_description) }}</textarea>
                </div>

                @php
                    $includesText = is_array($service->includes) ? implode("\n", $service->includes) : ($service->includes ?? '');
                    $timeSlotsText = implode("\n", $service->time_slots);
                @endphp
                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">What's Included In This Service (One item per line)</label>
                    <textarea name="includes_input" class="form-control" rows="5">{{ old('includes_input', $includesText) }}</textarea>
                    <small class="text-muted">Type each included feature on a new line. They will appear as checklist items on the website.</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Preferred Booking Time Slots (One option per line)</label>
                    <textarea name="time_slots_input" class="form-control" rows="4">{{ old('time_slots_input', $timeSlotsText) }}</textarea>
                    <small class="text-muted">Type each available booking time slot for this service on a new line.</small>
                </div>

                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ $service->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_featured">Show as Featured Service</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $service->is_active ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_active">Active on Website</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i> Update Service</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
