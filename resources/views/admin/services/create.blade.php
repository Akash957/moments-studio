@extends('layouts.admin')

@section('title', 'Add New Service')
@section('page_title', 'Add Photography Service')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus me-2"></i> Create New Service</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Service Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Wedding Photography" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Service Category</label>
                    <select name="category_id" class="form-control form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Icon Class (FontAwesome)</label>
                    <input type="text" name="icon" class="form-control" placeholder="fas fa-camera">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Upload Featured Cover Image</label>
                    <input type="file" name="image_file" class="form-control" accept="image/*">
                    <small class="text-muted">Upload photo from computer (JPG, PNG, WEBP)</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Image URL</label>
                    <input type="text" name="featured_image" class="form-control" placeholder="https://images.unsplash.com/...">
                    <small class="text-muted">Direct image URL if external photo</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Starting Price (₹) *</label>
                    <input type="number" name="starting_price" class="form-control" placeholder="45000" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Tagline / Subheading</label>
                    <input type="text" name="tagline" class="form-control" placeholder="e.g. Turning Your Wedding Moments into Timeless Memories">
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Short Summary Description</label>
                    <textarea name="short_description" class="form-control" rows="2" placeholder="Brief 1-2 sentence overview of service..."></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Full Detailed Description</label>
                    <textarea name="long_description" class="form-control" rows="5" placeholder="Complete detailed information, process, equipment, and story..."></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">What's Included In This Service (One item per line)</label>
                    <textarea name="includes_input" class="form-control" rows="5" placeholder="High-Resolution Edited Digital Photos&#10;Full Raw Footage Access (Optional)&#10;Professional Color Grading & Retouching&#10;Private Password-Protected Online Gallery&#10;Experienced Senior Lead Photographers&#10;Fast 30-Day Delivery Timeline"></textarea>
                    <small class="text-muted">Type each included feature on a new line. They will appear as checklist items on the website.</small>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Preferred Booking Time Slots (One option per line)</label>
                    <textarea name="time_slots_input" class="form-control" rows="4" placeholder="Full Day (Morning to Night)&#10;Morning Session (6 AM - 12 PM)&#10;Evening / Reception (4 PM - 11 PM)&#10;Custom Hours"></textarea>
                    <small class="text-muted">Type each available booking time slot for this service on a new line.</small>
                </div>

                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
                        <label class="form-check-label font-weight-bold" for="is_featured">Show as Featured Service</label>
                    </div>
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-center">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label font-weight-bold" for="is_active">Active on Website</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save me-1"></i> Save Service</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
