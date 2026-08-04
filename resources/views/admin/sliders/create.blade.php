@extends('layouts.admin')

@section('title', 'Add New Slide')
@section('page_title', 'Add Homepage Hero Slide')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-plus mr-2"></i> Create Hero Slide</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sliders.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Slide Main Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. We Capture Timeless Moments" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subtitle / Top Tagline</label>
                    <input type="text" name="subtitle" class="form-control" placeholder="e.g. PRE WEDDING | ENGAGEMENT | MATERNITY">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Background Image URL / Path *</label>
                    <input type="text" name="image" class="form-control" placeholder="https://images.unsplash.com/..." required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Description / Paragraph Text</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="Preserving your best moments with creativity and perfection."></textarea>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Button 1 Text</label>
                    <input type="text" name="button_text" class="form-control" value="OUR SERVICES">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Button 1 URL</label>
                    <input type="text" name="button_url" class="form-control" value="/services">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Button 2 Text</label>
                    <input type="text" name="button_text_2" class="form-control" value="BOOK NOW">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Button 2 URL</label>
                    <input type="text" name="button_url_2" class="form-control" value="/booking">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="0">
                </div>
                <div class="col-md-6 mb-3 d-flex align-items-end">
                    <div class="form-check mb-2">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" checked>
                        <label class="form-check-label" for="is_active">Active Slide</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> Save Hero Slide</button>
            <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
