@extends('layouts.admin')

@section('title', 'Media Manager')
@section('page_title', 'Studio Media Library & Assets')

@section('content')
<!-- Upload / Add New Asset Form -->
<div class="card card-outline card-warning mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload New Media Asset</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-5 mb-3 mb-md-0">
                    <label class="form-label font-weight-bold">Upload Local Image/File</label>
                    <input type="file" name="file" class="form-control bg-dark text-white" accept="image/*">
                </div>
                <div class="col-md-1 text-center font-weight-bold text-muted my-2">OR</div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="form-label font-weight-bold">Add External Image URL</label>
                    <input type="url" name="url" class="form-control" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="col-md-2 mt-md-4">
                    <button type="submit" class="btn btn-gold w-100"><i class="fas fa-plus mr-1"></i> Add Media</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Media Library Grid -->
<div class="card card-outline card-warning">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title"><i class="fas fa-folder-open mr-2"></i> Media Library ({{ $media->total() }} Assets)</h3>
    </div>
    <div class="card-body">
        <div class="row g-4">
            @forelse($media as $m)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="card h-100 bg-dark text-white border-secondary shadow-sm">
                    <div class="position-relative overflow-hidden bg-black text-center" style="height:140px;">
                        <img src="{{ $m->url }}" class="card-img-top w-100 h-100" alt="{{ $m->name }}" style="object-fit:cover;" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1519741497674-611481863552?w=400';">
                        <span class="badge badge-warning position-absolute top-0 right-0 m-1">{{ strtoupper($m->extension ?? 'IMG') }}</span>
                    </div>
                    <div class="card-body p-2 text-center">
                        <p class="card-text small text-truncate mb-1" title="{{ $m->name }}"><strong>{{ $m->name }}</strong></p>
                        <small class="text-muted d-block mb-2">{{ round(($m->size ?? 1024) / 1024, 2) }} KB</small>
                        <div class="d-flex justify-content-center gap-1">
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $m->url }}'); alert('Asset URL Copied!')" class="btn btn-xs btn-info me-1" title="Copy URL">
                                <i class="fas fa-copy"></i> Copy
                            </button>
                            <form action="{{ route('admin.media.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this media asset?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <p class="text-muted fs-5">No media files uploaded yet in the library.</p>
            </div>
            @endforelse
        </div>
    </div>
    <div class="card-footer">
        {{ $media->links() }}
    </div>
</div>
@endsection
