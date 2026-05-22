@extends('layouts.app')

@section('title', 'Paket Pernikahan - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" data-aos="fade-up">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paket Pernikahan</li>
        </ol>
    </nav>
    
    <h2 class="section-title" data-aos="fade-up">🎁 Paket Pernikahan 🎁</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up">Pilih paket yang sesuai dengan kebutuhan dan impian pernikahan Anda</p>
    
    <!-- Alert untuk user yang belum login -->
    @guest
    <div class="alert alert-warning alert-dismissible fade show mb-4 text-center" role="alert" data-aos="fade-up">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Perhatian!</strong> Silakan <a href="{{ route('login') }}" class="alert-link">login terlebih dahulu</a> atau 
        <a href="{{ route('register') }}" class="alert-link">daftar akun</a> untuk dapat memilih paket pernikahan.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endguest
    
    <div class="row">
        @foreach($packages as $package)
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="package-card card h-100 shadow border-0">
                @if($package->is_popular)
                <div class="popular-badge">
                    <i class="fas fa-fire"></i> Paling Populer
                </div>
                @endif
                <div class="card-body text-center">
                    <div class="package-icon">
                        @if($package->name == 'Paket Silver')
                            <i class="fas fa-gem"></i>
                        @elseif($package->name == 'Paket Gold')
                            <i class="fas fa-crown"></i>
                        @else
                            <i class="fas fa-star"></i>
                        @endif
                    </div>
                    <h3 class="card-title mt-3">{{ $package->name }}</h3>
                    
                    <div class="package-price">
                        <span class="price-label">Mulai dari</span>
                        <h2 class="text-gold">Rp {{ number_format($package->price, 0, ',', '.') }}</h2>
                    </div>
                    
                    @if(is_array($package->features) || is_object($package->features))
                        <ul class="package-features list-unstyled mt-3 text-start">
                            @foreach($package->features as $feature)
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-gold me-2"></i> 
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Fitur tidak tersedia</p>
                    @endif
                    
                    <div class="package-action mt-4">
                        @auth
                            <a href="javascript:void(0)" onclick="selectPackage('{{ $package->name }}')" class="btn btn-gold w-100">
                                <i class="fas fa-paper-plane me-2"></i> Pilih {{ $package->name }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-gold w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Login untuk Memilih
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Tombol Kembali ke Layanan -->
    <div class="text-center mt-5" data-aos="fade-up">
        <a href="{{ route('services') }}" class="btn btn-outline-gold btn-lg">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Layanan
        </a>
    </div>
    

<style>
    .btn-gold {
        background-color: #d4af37;
        color: white;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 12px 25px;
        font-weight: 500;
    }
    
    .btn-gold:hover {
        background-color: #c5a028;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
    }
    
    .btn-outline-gold {
        border: 1px solid #d4af37;
        color: #d4af37;
        background: transparent;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 12px 25px;
        font-weight: 500;
    }
    
    .btn-outline-gold:hover {
        background-color: #d4af37;
        color: white;
        transform: translateY(-2px);
    }
    
    .package-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .package-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.2);
    }
    
    .popular-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #d4af37, #c5a028);
        color: white;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        z-index: 10;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .popular-badge i {
        margin-right: 4px;
        font-size: 10px;
    }
    
    .package-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #d4af37, #c5a028);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .package-icon i {
        font-size: 32px;
        color: white;
    }
    
    .card-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
    }
    
    .package-price {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e0e0e0;
    }
    
    .price-label {
        font-size: 12px;
        color: #999;
        display: block;
        margin-bottom: 5px;
    }
    
    .text-gold {
        color: #d4af37;
    }
    
    .package-features {
        padding: 0 10px;
    }
    
    .package-features li {
        font-size: 13px;
        color: #555;
        padding: 5px 0;
    }
    
    .package-features i {
        width: 20px;
    }
    
    .consultation-card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }
    
    .consultation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(212, 175, 55, 0.15);
    }
    
    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item a {
        color: #d4af37;
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        text-decoration: underline;
    }
    
    .breadcrumb-item.active {
        color: #6c757d;
    }
    
    /* Section Title */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 20px;
        position: relative;
        color: #333;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #d4af37, #f3e5ab);
        border-radius: 3px;
    }
    
    /* Alert styling */
    .alert-warning {
        background: linear-gradient(135deg, #fff3e0, #ffe0b2);
        border: none;
        border-left: 4px solid #ff9800;
        border-radius: 12px;
    }
    
    .alert-warning .alert-link {
        color: #d4af37;
        font-weight: 600;
        text-decoration: none;
    }
    
    .alert-warning .alert-link:hover {
        text-decoration: underline;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .section-title {
            font-size: 1.8rem;
        }
        
        .card-title {
            font-size: 1.3rem;
        }
        
        .package-price h2 {
            font-size: 1.5rem;
        }
        
        .alert-warning {
            font-size: 0.85rem;
        }
    }
</style>

@push('scripts')
<script>
// Fungsi untuk memilih paket (hanya untuk user yang sudah login)
function selectPackage(packageName) {
    // Langsung redirect ke halaman kontak dengan parameter paket
    window.location.href = `/contact?package=${encodeURIComponent(packageName)}`;
}

// Fungsi untuk mengecek login (opsional, bisa digunakan untuk keperluan lain)
function checkLoginAndSelectPackage(packageName) {
    fetch('/check-login', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.logged_in) {
            window.location.href = `/contact?package=${encodeURIComponent(packageName)}`;
        } else {
            localStorage.setItem('selected_package', packageName);
            window.location.href = '{{ route("login") }}';
        }
    })
    .catch(error => {
        console.error('Error checking login:', error);
        window.location.href = `/contact?package=${encodeURIComponent(packageName)}`;
    });
}

// Animasi fade in untuk card
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.package-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
@endsection