@extends('layouts.admin')

@section('title', 'Awards & Recognition')
@section('page_title', 'Studio Awards & Achievements')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-award mr-2"></i> All Awards</h3>
        <a href="{{ route('admin.awards.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Add New Award</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Award Title</th>
                    <th>Year</th>
                    <th>Organization / Issuer</th>
                    <th>Featured</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($awards as $a)
                <tr>
                    <td><strong>{{ $a->title }}</strong></td>
                    <td><span class="badge badge-gold bg-warning text-dark">{{ $a->year }}</span></td>
                    <td>{{ $a->organization ?? 'N/A' }}</td>
                    <td>
                        @if($a->is_featured)
                        <span class="badge badge-success">Yes</span>
                        @else
                        <span class="badge badge-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <a href="{{ route('admin.awards.edit', $a->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.awards.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this award?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No awards added yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
