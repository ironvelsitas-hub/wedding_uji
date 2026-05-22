@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Layanan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Layanan</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*" required>
                <small class="text-muted">Upload gambar layanan (JPG, PNG, GIF, maks 2MB)</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="5" required></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-gold">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview image sebelum upload
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.createElement('div');
        preview.className = 'mt-2';
        preview.innerHTML = '<img src="' + URL.createObjectURL(e.target.files[0]) + '" class="img-thumbnail" style="height: 100px;">';
        
        const oldPreview = document.querySelector('.image-preview');
        if (oldPreview) oldPreview.remove();
        
        preview.classList.add('image-preview');
        e.target.parentNode.appendChild(preview);
    });
</script>
@endpush
@endsection