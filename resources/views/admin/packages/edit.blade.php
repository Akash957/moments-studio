@extends('layouts.admin')

@section('title', 'Edit Package')
@section('page_title', 'Edit Package')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i> Edit Package: {{ $package->name }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Package Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Linked Service Category</label>
                    <select name="service_id" class="form-control form-select">
                        <option value="">-- All / General Package --</option>
                        @foreach($services as $srv)
                        <option value="{{ $srv->id }}" {{ old('service_id', $package->service_id) == $srv->id ? 'selected' : '' }}>{{ $srv->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Badge Label</label>
                    <input type="text" name="badge" class="form-control" value="{{ old('badge', $package->badge) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Package Cover Image File (Upload)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($package->image || $package->cover_image)
                    <div class="mt-2">
                        <img src="{{ $package->image_url }}" alt="Package Image" class="img-thumbnail" style="max-height:60px;">
                    </div>
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">OR Package Cover Image URL</label>
                    <input type="url" name="image_url" class="form-control" value="{{ old('image_url', str_starts_with($package->image ?? '', 'http') ? $package->image : ($package->cover_image ?? '')) }}" placeholder="https://images.unsplash.com/photo-...">
                    <small class="text-muted">Upload an image file OR paste an Unsplash/Image URL for the package hero thumbnail.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Offer / Final Price (₹) *</label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $package->price) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Original Price (₹) (For Strike-Through & Discount Badge)</label>
                    <input type="number" name="original_price" class="form-control" value="{{ old('original_price', $package->original_price) }}">
                    <small class="text-muted">Shows strike-through price and auto-calculates Bachat % badge (e.g. Save ₹50,001 - 33% OFF).</small>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label font-weight-bold">Tagline / Subheading</label>
                    <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $package->tagline) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Coverage Hours</label>
                    <input type="number" name="hours" class="form-control" value="{{ old('hours', $package->hours) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Edited Photos Count</label>
                    <input type="number" name="edited_photos" class="form-control" value="{{ old('edited_photos', $package->edited_photos) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Photographers Count</label>
                    <input type="number" name="photographers" class="form-control" value="{{ old('photographers', $package->photographers) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Package Overview / Summary</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $package->description) }}</textarea>
                </div>

                @php
                    $featuresText = $package->features->pluck('feature')->implode("\n");
                @endphp
                <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">What's Included / Package Features Checklist (One item per line)</label>
                    <textarea name="features_input" class="form-control" rows="6">{{ old('features_input', $featuresText) }}</textarea>
                    <small class="text-muted">Type each included feature point on a new line. They will appear as checklist items with checkmarks on the website pricing cards.</small>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_video" value="1" class="form-check-input" id="includes_video" {{ $package->includes_video ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="includes_video"><i class="fas fa-video text-warning mr-1"></i> Includes 4K Video</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_drone" value="1" class="form-check-input" id="includes_drone" {{ $package->includes_drone ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="includes_drone"><i class="fas fa-plane text-warning mr-1"></i> Includes 4K Drone Aerial</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="includes_album" value="1" class="form-check-input" id="includes_album" {{ $package->includes_album ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="includes_album"><i class="fas fa-book-open text-warning mr-1"></i> Includes Printed Album</label>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_popular" value="1" class="form-check-input" id="is_popular" {{ $package->is_popular ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_popular">Highlight as Popular Choice</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" {{ $package->is_featured ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_featured">Featured on Homepage</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ $package->is_active ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="is_active">Active on Website</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Update Package</button>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
