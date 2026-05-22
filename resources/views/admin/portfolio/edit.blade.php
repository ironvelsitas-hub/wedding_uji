@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Portofolio</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.portfolio.update', $portfolio) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Judul Portofolio *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" value="{{ old('title', $portfolio->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori *</label>
                    <select class="form-control @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        <option value="wedding" {{ old('category', $portfolio->category) == 'wedding' ? 'selected' : '' }}>Pernikahan</option>
                        <option value="engagement" {{ old('category', $portfolio->category) == 'engagement' ? 'selected' : '' }}>Tunangan</option>
                        <option value="prewedding" {{ old('category', $portfolio->category) == 'prewedding' ? 'selected' : '' }}>Pre-wedding</option>
                        <option value="reception" {{ old('category', $portfolio->category) == 'reception' ? 'selected' : '' }}>Resepsi</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="client_name" class="form-label">Nama Klien</label>
                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                           id="client_name" name="client_name" value="{{ old('client_name', $portfolio->client_name) }}">
                    @error('client_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="venue" class="form-label">Lokasi/Venue</label>
                    <input type="text" class="form-control @error('venue') is-invalid @enderror" 
                           id="venue" name="venue" value="{{ old('venue', $portfolio->venue) }}">
                    @error('venue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="event_date" class="form-label">Tanggal Acara *</label>
                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                           id="event_date" name="event_date" value="{{ old('event_date', $portfolio->event_date ? $portfolio->event_date->format('Y-m-d') : '') }}" required>
                    @error('event_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
<div class="col-md-6 mb-3">
    <label for="video_url" class="form-label">Video URL (YouTube)</label>
    <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
           id="video_url" name="video_url" value="{{ old('video_url', $portfolio->video_url) }}" 
           placeholder="https://www.youtube.com/watch?v=VIDEO_ID atau https://youtu.be/VIDEO_ID">
    <small class="text-muted">
        <i class="fas fa-info-circle me-1"></i> 
        Masukkan URL YouTube (contoh: https://www.youtube.com/watch?v=xxxxxxxx atau https://youtu.be/xxxxxxxx)
    </small>
    @error('video_url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    
    @if($portfolio->video_url)
    <div class="mt-2">
        <div class="alert alert-info">
            <i class="fas fa-video me-2"></i>
            <strong>Preview Video:</strong><br>
            <div class="ratio ratio-16by9 mt-2">
                @php
                    $videoUrl = $portfolio->video_url;
                    if (strpos($videoUrl, 'youtube.com/watch') !== false) {
                        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $params);
                        if (isset($params['v'])) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $params['v'];
                        }
                    } elseif (strpos($videoUrl, 'youtu.be') !== false) {
                        $videoId = substr($videoUrl, strrpos($videoUrl, '/') + 1);
                        $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                    } else {
                        $embedUrl = $videoUrl;
                    }
                @endphp
                <iframe src="{{ $embedUrl }}?autoplay=0&rel=0" 
                        frameborder="0" 
                        allowfullscreen>
                </iframe>
            </div>
            <small class="text-muted mt-2 d-block">Preview video saat ini</small>
        </div>
    </div>
    @endif
</div>                
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Deskripsi *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required>{{ old('description', $portfolio->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Foto Utama</label>
                    @if($portfolio->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $portfolio->image) }}" 
                                 class="img-thumbnail" 
                                 style="height: 150px;" alt="Current Image">
                            <br>
                            <small class="text-muted">Foto saat ini</small>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah. Maksimal 5MB, format: JPG, PNG, GIF</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="gallery" class="form-label">Galeri Foto (Multiple)</label>
                    @if($portfolio->gallery && count($portfolio->gallery) > 0)
                        <div class="mb-2">
                            <div class="row">
                                @foreach($portfolio->gallery as $galleryImage)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset('storage/' . $galleryImage) }}" 
                                         class="img-thumbnail" 
                                         style="height: 80px; width: 100%; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted">{{ count($portfolio->gallery) }} foto dalam galeri</small>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                           id="gallery" name="gallery[]" accept="image/*" multiple>
                    <small class="text-muted">Bisa pilih lebih dari satu foto, maksimal 5MB per foto</small>
                    @error('gallery.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                               {{ old('is_featured', $portfolio->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning"></i> Jadikan Featured (Tampil di halaman depan)
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-gold">Update Portfolio</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('image')?.addEventListener('change', function(e) {
        const previewDiv = document.querySelector('.image-preview');
        if (previewDiv) previewDiv.remove();
        
        if (e.target.files && e.target.files[0]) {
            const preview = document.createElement('div');
            preview.className = 'mt-2 image-preview';
            preview.innerHTML = '<img src="' + URL.createObjectURL(e.target.files[0]) + '" class="img-thumbnail" style="height: 150px;">';
            e.target.parentNode.appendChild(preview);
        }
    });
    
    // Preview multiple gallery images
    document.getElementById('gallery')?.addEventListener('change', function(e) {
        const previewDiv = document.querySelector('.gallery-preview');
        if (previewDiv) previewDiv.remove();
        
        const container = document.createElement('div');
        container.className = 'mt-2 gallery-preview';
        container.innerHTML = '<div class="row" id="galleryPreview"></div>';
        e.target.parentNode.appendChild(container);
        
        const galleryPreview = document.getElementById('galleryPreview');
        if (e.target.files) {
            for (let i = 0; i < e.target.files.length; i++) {
                const file = e.target.files[i];
                const col = document.createElement('div');
                col.className = 'col-md-2 mb-2';
                col.innerHTML = '<img src="' + URL.createObjectURL(file) + '" class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">';
                galleryPreview.appendChild(col);
            }
        }
    });
</script>
@endpush
@endsection