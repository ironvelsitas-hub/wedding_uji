<!-- resources/views/admin/portfolio/index.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Portofolio</h1>
    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i> Tambah Portofolio
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    @foreach($portfolios as $portfolio)
    <div class="col-md-3 mb-4">
        <div class="card h-100">
            @if($portfolio->image)
                <img src="{{ asset('storage/' . $portfolio->image) }}" 
                     class="card-img-top" 
                     alt="{{ $portfolio->title }}"
                     style="height: 200px; object-fit: cover;">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-image fa-3x text-white"></i>
                </div>
            @endif
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ Str::limit($portfolio->title, 30) }}</h5>
                    @if($portfolio->is_featured)
                        <span class="badge bg-warning">
                            <i class="fas fa-star"></i> Featured
                        </span>
                    @endif
                </div>
                
                <p class="card-text small text-muted">
                    <i class="fas fa-calendar-alt me-1"></i> {{ $portfolio->event_date->format('d M Y') }}
                </p>
                
                <p class="card-text small">{{ Str::limit($portfolio->description, 80) }}</p>
                
                <div class="mt-2">
                    <span class="badge bg-info">{{ ucfirst($portfolio->category) }}</span>
                    @if($portfolio->gallery)
                        <span class="badge bg-secondary">
                            <i class="fas fa-images"></i> {{ count($portfolio->gallery) }} foto
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="card-footer bg-transparent">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('admin.portfolio.edit', $portfolio) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal{{ $portfolio->id }}">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <form action="{{ route('admin.portfolio.destroy', $portfolio) }}" method="POST" 
                          style="display: inline-block;" 
                          onsubmit="return confirm('Yakin ingin menghapus portfolio ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal View Portfolio -->
    <div class="modal fade" id="viewModal{{ $portfolio->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $portfolio->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($portfolio->image)
                        <img src="{{ asset('storage/' . $portfolio->image) }}" class="img-fluid rounded mb-3" alt="{{ $portfolio->title }}">
                    @endif
                    
                    <h6>Deskripsi:</h6>
                    <p>{{ $portfolio->description }}</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-calendar"></i> Tanggal:</strong><br>
                            {{ $portfolio->event_date->format('d F Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag"></i> Kategori:</strong><br>
                            {{ ucfirst($portfolio->category) }}</p>
                        </div>
                        @if($portfolio->client_name)
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Klien:</strong><br>
                            {{ $portfolio->client_name }}</p>
                        </div>
                        @endif
                        @if($portfolio->venue)
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt"></i> Venue:</strong><br>
                            {{ $portfolio->venue }}</p>
                        </div>
                        @endif
                    </div>
                    
                    @if($portfolio->gallery && count($portfolio->gallery) > 0)
                        <h6 class="mt-3">Galeri Foto:</h6>
                        <div class="row">
                            @foreach($portfolio->gallery as $galleryImage)
                            <div class="col-md-4 mb-2">
                                <img src="{{ asset('storage/' . $galleryImage) }}" 
                                     class="img-fluid rounded" 
                                     style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;"
                                     onclick="window.open(this.src)">
                            </div>
                            @endforeach
                        </div>
                    @endif
                    
                    @if($portfolio->video_url)
                        <h6 class="mt-3">Video:</h6>
                        <div class="ratio ratio-16by9">
                            <iframe src="{{ $portfolio->video_url }}" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $portfolios->links() }}
</div>

<style>
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-radius: 5px 0 0 5px;
    }
    .btn-group .btn:last-child {
        border-radius: 0 5px 5px 0;
    }
</style>
@endsection