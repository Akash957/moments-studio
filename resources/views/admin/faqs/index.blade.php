@extends('layouts.admin')

@section('title', 'FAQs Management')
@section('page_title', 'Frequently Asked Questions')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-question-circle mr-2"></i> All FAQs ({{ $faqs->total() }})</h3>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add New FAQ</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $f)
                <tr>
                    <td><strong>{{ $f->question }}</strong><br><small class="text-muted">{{ Str::limit(strip_tags($f->answer), 80) }}</small></td>
                    <td>{{ $f->category?->name ?? 'General' }}</td>
                    <td>
                        @if($f->is_active ?? true)
                        <span class="badge badge-success">Active</span>
                        @else
                        <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.faqs.edit', $f->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.faqs.destroy', $f->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this FAQ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">No FAQs added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $faqs->links() }}
    </div>
</div>
@endsection
