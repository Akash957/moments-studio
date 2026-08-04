@extends('layouts.admin')

@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')
@section('page_title', isset($faq) ? 'Edit Question' : 'Add Question')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-question-circle mr-2"></i> {{ isset($faq) ? 'Edit FAQ' : 'Create FAQ' }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ isset($faq) ? route('admin.faqs.update', $faq->id) : route('admin.faqs.store') }}" method="POST">
            @csrf
            @if(isset($faq)) @method('PUT') @endif
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Question *</label>
                    <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}" placeholder="e.g. How far in advance should we book?" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (isset($faq) && $faq->category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Detailed Answer *</label>
                    <textarea name="answer" class="form-control" rows="5" required placeholder="Write the answer for clients...">{{ old('answer', $faq->answer ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ (isset($faq) && $faq->is_active) || !isset($faq) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-gold"><i class="fas fa-save mr-1"></i> {{ isset($faq) ? 'Update FAQ' : 'Save FAQ' }}</button>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</div>
@endsection
