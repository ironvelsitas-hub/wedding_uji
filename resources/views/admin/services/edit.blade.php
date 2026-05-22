@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Layanan</h1>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $service->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Layanan</label>
                @if($service->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             class="img-thumbnail" 
                             style="height: 100px;" alt="Current Image">
                        <br>
                        <small class="text-muted">Gambar saat ini</small>
                    </div>
                @endif
                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                       id="image" name="image" accept="image/*">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-gold">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.querySelector('.image-preview');
        if (preview) preview.remove();
        
        if (e.target.files && e.target.files[0]) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'mt-2 image-preview';
            previewDiv.innerHTML = '<img src="' + URL.createObjectURL(e.target.files[0]) + '" class="img-thumbnail" style="height: 100px;">';
            e.target.parentNode.appendChild(previewDiv);
        }
    });
</script>
@endpush
@endsection