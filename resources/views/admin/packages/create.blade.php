@extends('layouts.admin')

@section('title', 'Add New Package')
@section('page_title', 'Create Package')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Create Package</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Package Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Deluxe Wedding Package" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Linked Service Category</label>
                    <select name="service_id" class="form-control form-select">
                        <option value="">-- All / General Package --</option>
                        @foreach($services as $srv)
                        <option value="{{ $srv->id }}">{{ $srv->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Badge Label</label>
                    <input type="text" name="badge" class="form-control" placeholder="e.g. Best Value / 33% OFF">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Package Cover Image File (Upload)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Package Cover Image URL</label>
                    <input type="url" name="image_url" class="form-control" placeholder="https://images.unsplash.com/photo-...">
                    <small class="text-muted">Upload an image file OR paste an Unsplash/Image URL for the package hero thumbnail.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Offer / Final Price (₹) *</label>
                    <input type="number" name="price" class="form-control" placeholder="99999" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Original Price (₹) (For Strike-Through & Discount Badge)</label>
                    <input type="number" name="original_price" class="form-control" placeholder="150000">
                    <small class="text-muted">Shows strike-through price and auto-calculates Bachat % badge (e.g. Save ₹50,001 - 33% OFF).</small>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label font-weight-bold">Tagline / Subheading</label>
                    <input type="text" name="tagline" class="form-control" placeholder="e.g. Most Popular Choice for Grand Weddings">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Coverage Hours</label>
                    <input type="number" name="hours" class="form-control" value="8">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Edited Photos Count</label>
                    <input type="number" name="edited_photos" class="form-control" value="500">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Photographers Count</label>
                    <input type="number" name="photographers" class="form-control" value="2">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Package Overview / Summary</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Package overview, ideal coverage scope, and studio highlight..."></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">What's Included / Package Features Checklist (One item per line)</label>
                    <textarea name="features_input" class="form-control" rows="6" placeholder="Full 4K Cinematic Teaser + Extended Wedding Film&#10;Pre-Wedding Couple Shoot Included&#10;All Original RAW Files Provided on Hard Drive&#10;Private Password-Protected Online Gallery&#10;Fast 30-Day Express Delivery Timeline&#10;2 Premium Canvera Glass Cover Photobooks (40 Pages Each)"></textarea>
                    <small class="text-muted">Type each included feature point on a new line. They will appear as checklist items with checkmarks on the website pricing cards.</small>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_video" value="1" class="form-check-input" id="includes_video" checked>
                        <label class="form-check-label font-weight-bold" for="includes_video"><i class="fas fa-video text-warning mr-1"></i> Includes 4K Video</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_drone" value="1" class="form-check-input" id="includes_drone" checked>
                        <label class="form-check-label font-weight-bold" for="includes_drone"><i class="fas fa-plane text-warning mr-1"></i> Includes 4K Drone Aerial</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_album" value="1" class="form-check-input" id="includes_album" checked>
                        <label class="form-check-label font-weight-bold" for="includes_album"><i class="fas fa-book-open text-warning mr-1"></i> Includes Printed Album</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_popular" value="1" class="form-check-input" id="is_popular" checked>
                        <label class="form-check-label font-weight-bold" for="is_popular">Highlight as Popular Choice</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" checked>
                        <label class="form-check-label font-weight-bold" for="is_featured">Featured on Homepage</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label font-weight-bold" for="is_active">Active on Website</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
