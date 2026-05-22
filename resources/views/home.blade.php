@extends('layouts.app')

@section('title', 'Perfect Wedding - Wedding Organizer Terbaik')

@section('content')
<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3') center/cover no-repeat fixed; height: 100vh; display: flex; align-items: center; color: white; position: relative;">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="hero-content">
                    <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInUp">Mewujudkan Pernikahan Impian Anda</h1>
                    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Kami hadir untuk membuat hari spesial Anda menjadi tak terlupakan dengan pelayanan profesional dan detail yang sempurna.</p>
                    <a href="{{ route('services') }}" class="btn btn-gold btn-lg animate__animated animate__fadeInUp animate__delay-2s">✨ Konsultasi Gratis ✨</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-scroll-indicator">
        <a href="#services">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">✨ Layanan Kami ✨</h2>
        <div class="row">
            @foreach($services->take(3) as $service)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card text-center p-4 border rounded h-100">
                    <div class="service-icon-wrapper">
                        @if($service->image)
                            <div class="service-image-container">
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     class="service-image" 
                                     alt="{{ $service->name }}">
                            </div>
                        @else
                            <div class="service-icon-default">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                        @endif
                    </div>
                    <h4 class="service-title">{{ $service->name }}</h4>
                    <p class="service-description">{{ Str::limit($service->description, 100) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('services') }}" class="btn btn-outline-gold">
                Lihat Semua Layanan <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Packages Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">🎁 Paket Pernikahan 🎁</h2>
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
                            <i class="fas fa-gift"></i>
                        </div>
                        <h3 class="card-title mt-3">{{ $package->name }}</h3>
                        <div class="package-price">
                            <h2 class="text-gold">Rp {{ number_format($package->price, 0, ',', '.') }}</h2>
                        </div>
                        <a href="{{ route('packages') }}" class="btn btn-outline-gold w-100 mt-3">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="{{ route('packages') }}" class="btn btn-gold">
                Lihat Semua Paket <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title text-center mb-5">📸 Galeri Pernikahan 📸</h2>
        <div class="row g-4">
            @forelse($portfolios as $portfolio)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="portfolio-card">
                    <div class="portfolio-image-wrapper">
                        @if($portfolio->image)
                            <img src="{{ asset('storage/' . $portfolio->image) }}" class="portfolio-img" alt="{{ $portfolio->title }}">
                            <div class="portfolio-overlay">
                                <div class="portfolio-overlay-content">
                                    <i class="fas fa-search-plus fa-2x mb-2"></i>
                                    <h6>{{ $portfolio->title }}</h6>
                                    <small>{{ $portfolio->event_date ? $portfolio->event_date->format('d F Y') : '-' }}</small>
                                </div>
                            </div>
                        @else
                            <div class="portfolio-placeholder">
                                <i class="fas fa-image fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="portfolio-caption">
                        <h5>{{ $portfolio->title }}</h5>
                        <p class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $portfolio->event_date ? $portfolio->event_date->format('d F Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="empty-state">
                    <i class="fas fa-images fa-4x text-muted mb-3"></i>
                    <p>Belum ada data portfolio.</p>
                </div>
            </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('portfolio') }}" class="btn btn-gold btn-lg">
                <i class="fas fa-images me-2"></i> Lihat Semua Galeri
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light position-relative">
    <div class="container">
        <h2 class="section-title text-center mb-5">💬 Kata Mereka 💬</h2>
        <div class="row">
            @forelse($testimonials as $testimonial)
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="testimonial-card bg-white p-4 rounded shadow h-100">
                    <div class="testimonial-quote">
                        <i class="fas fa-quote-left"></i>
                    </div>
                    <div class="mb-3 rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="mb-3 testimonial-text">"{{ Str::limit($testimonial->message, 150) }}"</p>
                    <div class="d-flex align-items-center mt-3">
                        <div class="testimonial-avatar me-3">
                            <div class="avatar-circle">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $testimonial->client_name }}</h6>
                            <small class="text-muted">Pasangan Bahagia</small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="empty-state">
                    <i class="fas fa-star fa-4x text-muted mb-3"></i>
                    <p>Belum ada testimoni.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    /* Hero Section Enhancements */
    .hero {
        position: relative;
        overflow: hidden;
    }
    
    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(212, 175, 55, 0.15), transparent);
        pointer-events: none;
    }
    
    .hero-content {
        animation: fadeInUp 1s ease-out;
    }
    
    .hero-scroll-indicator {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        animation: bounce 2s infinite;
    }
    
    .hero-scroll-indicator a {
        color: white;
        font-size: 24px;
        opacity: 0.7;
        transition: opacity 0.3s;
    }
    
    .hero-scroll-indicator a:hover {
        opacity: 1;
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Service Card Styles */
    .service-card {
        transition: all 0.3s ease;
        background: white;
        border-radius: 15px;
        position: relative;
        overflow: hidden;
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
        width: 100px;
        height: 100px;
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
    
    .service-icon-default {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #d4af37, #c5a028);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: transform 0.3s;
    }
    
    .service-icon-default i {
        font-size: 45px;
        color: white;
    }
    
    .service-card:hover .service-icon-default {
        transform: scale(1.05);
    }
    
    .service-title {
        font-size: 1.3rem;
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
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    /* Package Card Styles */
    .package-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
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
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #d4af37, #c5a028);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    .package-icon i {
        font-size: 28px;
        color: white;
    }
    
    .card-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
    }
    
    .package-price {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e0e0e0;
    }
    
    .text-gold {
        color: #d4af37;
    }
    
    .btn-outline-gold {
        border: 1px solid #d4af37;
        color: #d4af37;
        background: transparent;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 10px 20px;
        font-weight: 500;
    }
    
    .btn-outline-gold:hover {
        background-color: #d4af37;
        color: white;
        transform: translateY(-2px);
    }
    
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
    
    /* Portfolio Card Styles */
    .portfolio-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        aspect-ratio: 1;
    }
    
    .portfolio-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .portfolio-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(212, 175, 55, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .portfolio-overlay-content {
        text-align: center;
        color: white;
        transform: translateY(20px);
        transition: transform 0.3s;
    }
    
    .portfolio-image-wrapper:hover .portfolio-overlay {
        opacity: 1;
    }
    
    .portfolio-image-wrapper:hover .portfolio-overlay-content {
        transform: translateY(0);
    }
    
    .portfolio-image-wrapper:hover .portfolio-img {
        transform: scale(1.1);
    }
    
    .portfolio-placeholder {
        width: 100%;
        height: 100%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    
    .portfolio-caption {
        padding: 15px 0;
        text-align: center;
    }
    
    /* Testimonial Card Styles */
    .testimonial-card {
        position: relative;
        transition: all 0.3s ease;
        border: none;
        border-radius: 20px;
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(212, 175, 55, 0.1);
    }
    
    .testimonial-quote {
        position: absolute;
        top: 20px;
        right: 20px;
        opacity: 0.1;
        font-size: 40px;
        color: #d4af37;
    }
    
    .testimonial-text {
        line-height: 1.6;
        color: #555;
    }
    
    .avatar-circle {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #d4af37, #c5a028);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-circle i {
        font-size: 24px;
        color: white;
    }
    
    .empty-state {
        padding: 60px 20px;
        text-align: center;
    }
    
    /* Section Title */
    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 50px;
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
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2rem;
        }
        
        .hero .lead {
            font-size: 1rem;
        }
        
        .section-title {
            font-size: 1.6rem;
        }
        
        .package-card {
            margin-bottom: 20px;
        }
        
        .service-image-container,
        .service-icon-default {
            width: 70px;
            height: 70px;
        }
        
        .service-icon-default i {
            font-size: 30px;
        }
    }
    
    /* Animation Delays */
    .animate__delay-1s {
        animation-delay: 0.3s;
    }
    
    .animate__delay-2s {
        animation-delay: 0.6s;
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
    // Add animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[data-aos]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });
        
        elements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    });
</script>
@endpush
@endsection