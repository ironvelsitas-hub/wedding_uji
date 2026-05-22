@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-circle me-2"></i> Profil Admin
    </h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <!-- Card Informasi Admin -->
    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="bg-gold rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 120px; height: 120px;">
                        <i class="fas fa-user-shield fa-4x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $admin->name }}</h4>
                <p class="text-muted mb-2">{{ $admin->email }}</p>
                <span class="badge bg-success">Administrator</span>
                
                <hr>
                
                <div class="text-start">
                    <p class="mb-2">
                        <strong><i class="fas fa-calendar-alt me-2 text-gold"></i> Terdaftar:</strong><br>
                        {{ $admin->created_at->format('d F Y H:i') }}
                    </p>
                    <p class="mb-0">
                        <strong><i class="fas fa-clock me-2 text-gold"></i> Terakhir Update:</strong><br>
                        {{ $admin->updated_at->format('d F Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Edit Profil -->
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-edit text-gold me-2"></i> Edit Profil
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i>
                        Password harus minimal 6 karakter.
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-gold">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Card Keamanan -->
        <div class="card shadow mt-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-shield-alt text-gold me-2"></i> Tips Keamanan
                </h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Gunakan password yang kuat dan unik</li>
                    <li>Jangan bagikan password kepada siapapun</li>
                    <li>Logout dari perangkat yang tidak dikenal</li>
                    <li>Hubungi administrator jika ada aktivitas mencurigakan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold {
        color: #d4af37;
    }
    
    .bg-gold {
        background-color: #d4af37;
    }
    
    .btn-gold {
        background-color: #d4af37;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-gold:hover {
        background-color: #c5a028;
        color: white;
        transform: translateY(-2px);
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
    }
    
    .input-group .form-control:focus {
        border-left: none;
        box-shadow: none;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }
</style>
@endsection