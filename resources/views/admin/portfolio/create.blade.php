<!-- resources/views/admin/portfolio/create.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Portofolio</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.portfolio.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Judul Portofolio *</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                           id="title" name="title" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">Kategori *</label>
                    <select class="form-control @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="client_name" class="form-label">Nama Klien</label>
                    <input type="text" class="form-control @error('client_name') is-invalid @enderror" 
                           id="client_name" name="client_name" placeholder="Contoh: Andi & Siska">
                    @error('client_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="venue" class="form-label">Lokasi/Venue</label>
                    <input type="text" class="form-control @error('venue') is-invalid @enderror" 
                           id="venue" name="venue" placeholder="Contoh: Hotel Indonesia, Jakarta">
                    @error('venue')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="event_date" class="form-label">Tanggal Acara *</label>
                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                           id="event_date" name="event_date" required>
                    @error('event_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
<div class="col-md-6 mb-3">
    <label for="video_url" class="form-label">Video URL (YouTube)</label>
    <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
           id="video_url" name="video_url" value="{{ old('video_url') }}" 
           placeholder="https://www.youtube.com/watch?v=VIDEO_ID atau https://youtu.be/VIDEO_ID">
    <small class="text-muted">
        <i class="fas fa-info-circle me-1"></i> 
        Masukkan URL YouTube (contoh: https://www.youtube.com/watch?v=xxxxxxxx)
    </small>
    @error('video_url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    
    <div id="videoPreview" class="mt-2" style="display: none;">
        <div class="alert alert-info">
            <i class="fas fa-video me-2"></i>
            <strong>Preview Video:</strong>
            <div class="ratio ratio-16by9 mt-2">
                <iframe id="videoPreviewFrame" src="" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<script>
// Live preview video
document.getElementById('video_url').addEventListener('input', function() {
    let url = this.value;
    let embedUrl = url;
    
    if (url.includes('youtube.com/watch')) {
        const urlParams = new URLSearchParams(new URL(url).search);
        const videoId = urlParams.get('v');
        if (videoId) {
            embedUrl = 'https://www.youtube.com/embed/' + videoId;
            document.getElementById('videoPreview').style.display = 'block';
            document.getElementById('videoPreviewFrame').src = embedUrl;
        }
    } else if (url.includes('youtu.be')) {
        const videoId = url.substring(url.lastIndexOf('/') + 1);
        embedUrl = 'https://www.youtube.com/embed/' + videoId;
        document.getElementById('videoPreview').style.display = 'block';
        document.getElementById('videoPreviewFrame').src = embedUrl;
    } else if (url.includes('youtube.com/embed')) {
        embedUrl = url;
        document.getElementById('videoPreview').style.display = 'block';
        document.getElementById('videoPreviewFrame').src = embedUrl;
    } else {
        document.getElementById('videoPreview').style.display = 'none';
    }
});
</script>                
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Deskripsi *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" required></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Foto Utama *</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*" required>
                    <small class="text-muted">Maksimal 5MB, format: JPG, PNG, GIF</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="gallery" class="form-label">Galeri Foto (Multiple)</label>
                    <input type="file" class="form-control @error('gallery.*') is-invalid @enderror" 
                           id="gallery" name="gallery[]" accept="image/*" multiple>
                    <small class="text-muted">Bisa pilih lebih dari satu foto, maksimal 5MB per foto</small>
                    @error('gallery.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured">
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning"></i> Jadikan Featured (Tampil di halaman depan)
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.portfolio.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-gold">Simpan Portfolio</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.createElement('div');
        preview.className = 'mt-2';
        preview.innerHTML = '<img src="' + URL.createObjectURL(e.target.files[0]) + '" class="img-thumbnail" style="height: 150px;">';
        
        const oldPreview = document.querySelector('.image-preview');
        if (oldPreview) oldPreview.remove();
        
        preview.classList.add('image-preview');
        e.target.parentNode.appendChild(preview);
    });
</script>
@endpush
@endsection