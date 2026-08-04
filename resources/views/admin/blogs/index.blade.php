@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page_title', 'Blog & Articles Management')

@section('content')
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-newspaper mr-2"></i> All Articles</h3>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-gold btn-sm"><i class="fas fa-plus mr-1"></i> Write New Story</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published At</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($blogs as $b)
                <tr>
                    <td><strong>{{ $b->title }}</strong><br><small class="text-muted">{{ Str::limit($b->excerpt, 60) }}</small></td>
                    <td>{{ $b->category?->name ?? 'General' }}</td>
                    <td>{{ $b->author?->name ?? 'Admin' }}</td>
                    <td>
                        @if($b->status === 'published')
                        <span class="badge badge-success">Published</span>
                        @else
                        <span class="badge badge-warning">Draft</span>
                        @endif
                    </td>
                    <td>{{ $b->published_at?->format('M d, Y') ?? 'N/A' }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-secondary me-1" data-toggle="modal" data-target="#viewModal{{ $b->id }}"><i class="fas fa-eye"></i> View</button>
                        <a href="{{ route('admin.blogs.edit', $b->id) }}" class="btn btn-sm btn-info me-1"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.blogs.destroy', $b->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this blog post?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>

                        <!-- View Article Modal -->
                        <div class="modal fade text-left" id="viewModal{{ $b->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header border-secondary">
                                        <h5 class="modal-title text-gold"><i class="fas fa-newspaper mr-2"></i> {{ $b->title }}</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @if($b->featured_image)
                                        <img src="{{ $b->featured_image }}" alt="{{ $b->title }}" class="img-fluid rounded mb-3 border border-secondary" style="max-height:300px;width:100%;object-fit:cover;">
                                        @endif
                                        <p class="mb-1"><strong>Category:</strong> {{ $b->category?->name ?? 'General' }} | <strong>Published:</strong> {{ $b->published_at?->format('M d, Y') ?? 'Draft' }}</p>
                                        <p class="text-gold mb-2 font-italic">{{ $b->excerpt }}</p>
                                        <hr class="border-secondary">
                                        <div class="bg-black p-3 rounded border border-secondary" style="max-height:300px;overflow-y:auto;">
                                            {!! $b->content !!}
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{ route('admin.blogs.edit', $b->id) }}" class="btn btn-gold">Edit Article</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No stories published yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $blogs->links() }}
    </div>
</div>
@endsection
