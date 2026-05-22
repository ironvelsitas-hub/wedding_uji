@extends('layouts.app')

@section('title', 'Layanan Kami - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" data-aos="fade-up">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Layanan Kami</li>
        </ol>
    </nav>
    
    <h2 class="section-title" data-aos="fade-up">✨ Layanan Kami ✨</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up">Kami menyediakan berbagai layanan profesional untuk mewujudkan pernikahan impian Anda</p>
    
    <div class="row">
        @foreach($services as $service)
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="service-card text-center p-4 border rounded h-100">
                <div class="service-icon-wrapper">
                    @if($service->image)
                        <div class="service-image-container">
                            <img src="{{ asset('storage/' . $service->image) }}" 
                                 class="service-image" 
                                 alt="{{ $service->name }}">
                            <div class="service-image-overlay">
                                <i class="fas fa-search-plus"></i>
                                <span>Lihat Detail</span>
                            </div>
                        </div>
                    @else
                        <div class="service-icon-default">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                    @endif
                </div>
                <h4 class="service-title">{{ $service->name }}</h4>
                <p class="service-description">{{ $service->description }}</p>
                <div class="service-hover-effect"></div>
                <div class="service-read-more mt-3">
                    <a href="javascript:void(0)" onclick="checkLoginAndSelectService('{{ $service->id }}')" class="btn btn-outline-gold btn-sm">
                        Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Tombol Menuju Halaman Paket -->
    <div class="text-center mt-5" data-aos="fade-up">
        <a href="{{ route('packages') }}" class="btn btn-gold btn-lg">
            <i class="fas fa-gift me-2"></i> Lihat Paket Pernikahan
            <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<style>
    .btn-gold {
        background-color: #d4af37;
        color: white;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 12px 30px;
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
        padding: 6px 20px;
    }
    
    .btn-outline-gold:hover {
        background-color: #d4af37;
        color: white;
    }
    
    /* Service Card Styles */
    .service-card {
        position: relative;
        transition: all 0.4s ease;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        cursor: pointer;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.15);
    }
    
    .service-icon-wrapper {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .service-image-container {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin: 0 auto;
    }
    
    .service-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .service-card:hover .service-image {
        transform: scale(1.1);
    }
    
    .service-image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(212, 175, 55, 0.85);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
        gap: 5px;
    }
    
    .service-image-overlay i {
        color: white;
        font-size: 24px;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }
    
    .service-image-overlay span {
        color: white;
        font-size: 11px;
        font-weight: 500;
    }
    
    .service-image-container:hover .service-image-overlay {
        opacity: 1;
    }
    
    .service-card:hover .service-image-overlay i {
        transform: scale(1);
    }
    
    .service-icon-default {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
        margin: 0 auto;
    }
    
    .service-icon-default i {
        font-size: 50px;
        color: white;
        transition: transform 0.3s ease;
    }
    
    .service-card:hover .service-icon-default {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }
    
    .service-card:hover .service-icon-default i {
        transform: scale(1.1);
    }
    
    .service-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 15px 0 10px;
        color: #333;
        transition: color 0.3s ease;
    }
    
    .service-card:hover .service-title {
        color: #d4af37;
    }
    
    .service-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
        font-size: 0.9rem;
    }
    
    .service-hover-effect {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 3px;
        background: linear-gradient(90deg, #d4af37, #f3e5ab);
        transition: width 0.4s ease;
    }
    
    .service-card:hover .service-hover-effect {
        width: 100%;
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .service-image-container,
        .service-icon-default {
            width: 90px;
            height: 90px;
        }
        
        .service-icon-default i {
            font-size: 35px;
        }
        
        .service-title {
            font-size: 1.2rem;
        }
        
        .service-description {
            font-size: 0.85rem;
        }
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
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@push('scripts')
<script>
// Fungsi untuk menangani klik layanan
function checkLoginAndSelectService(serviceId) {
    fetch('/check-login', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.logged_in) {
            window.location.href = `/contact?service=${encodeURIComponent(serviceId)}`;
        } else {
            localStorage.setItem('selected_service', serviceId);
            showLoginModal();
        }
    })
    .catch(error => {
        console.error('Error checking login:', error);
        window.location.href = `/contact?service=${encodeURIComponent(serviceId)}`;
    });
}
</script>
@endpush
@endsection