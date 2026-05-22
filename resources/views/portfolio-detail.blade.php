@extends('layouts.app')

@section('title', $portfolio->title . ' - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" data-aos="fade-up">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('portfolio') }}">Portofolio</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $portfolio->title }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-lg-8" data-aos="fade-right">
            <!-- Main Image -->
            <div class="portfolio-main-image mb-4">
                <img src="{{ asset('storage/' . $portfolio->image) }}" 
                     class="img-fluid rounded w-100" 
                     alt="{{ $portfolio->title }}"
                     style="max-height: 500px; object-fit: cover;">
            </div>
            
            <!-- Title & Description -->
            <div class="portfolio-header mb-4">
                <h1 class="display-5 mb-3">{{ $portfolio->title }}</h1>
                
                <div class="portfolio-meta d-flex flex-wrap gap-3 mb-3">
                    <span class="badge bg-info">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        {{ $portfolio->event_date->format('d F Y') }}
                    </span>
                    <span class="badge bg-secondary">
                        <i class="fas fa-tag me-1"></i> 
                        {{ ucfirst($portfolio->category) }}
                    </span>
                    @if($portfolio->is_featured)
                        <span class="badge bg-warning">
                            <i class="fas fa-star me-1"></i> Featured
                        </span>
                    @endif
                </div>
                
                <div class="portfolio-info card bg-light p-3 mb-4">
                    <div class="row">
                        @if($portfolio->client_name)
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="fas fa-user-circle text-gold me-2"></i>
                                <strong>Klien:</strong> {{ $portfolio->client_name }}
                            </p>
                        </div>
                        @endif
                        
                        @if($portfolio->venue)
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt text-gold me-2"></i>
                                <strong>Venue:</strong> {{ $portfolio->venue }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="portfolio-description">
                    <h3 class="h4 mb-3">Deskripsi Acara</h3>
                    <p>{{ $portfolio->description }}</p>
                </div>
            </div>
            
            <!-- Gallery Section -->
            @if($portfolio->gallery && count($portfolio->gallery) > 0)
            <div class="portfolio-gallery mt-5">
                <h3 class="h4 mb-4">Galeri Foto</h3>
                <div class="row g-3">
                    @foreach($portfolio->gallery as $index => $galleryImage)
                    <div class="col-md-4">
                        <div class="gallery-item position-relative overflow-hidden rounded" 
                             style="cursor: pointer; height: 200px;">
                            <img src="{{ asset('storage/' . $galleryImage) }}" 
                                 class="img-fluid w-100 h-100" 
                                 style="object-fit: cover; transition: transform 0.3s;"
                                 alt="Gallery {{ $index + 1 }}"
                                 onclick="openLightbox({{ $index }})">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Video Section -->
            @if($portfolio->video_url)
            <div class="portfolio-video mt-5">
                <h3 class="h4 mb-4">
                    <i class="fas fa-video text-gold me-2"></i> 
                    Video Dokumentasi
                </h3>
                <div class="ratio ratio-16by9 shadow rounded overflow-hidden">
                    @php
                        $videoUrl = trim($portfolio->video_url);
                        $embedUrl = null;
                        
                        // Cek URL YouTube
                        if (strpos($videoUrl, 'youtube.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
                            // Extract video ID
                            $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
                            preg_match($pattern, $videoUrl, $matches);
                            
                            if (isset($matches[1])) {
                                $videoId = $matches[1];
                                $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                            }
                        } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                            $pattern = '/(?:vimeo\.com\/)(\d+)/';
                            preg_match($pattern, $videoUrl, $matches);
                            if (isset($matches[1])) {
                                $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                            }
                        } else {
                            $embedUrl = $videoUrl;
                        }
                        
                        if (!$embedUrl) {
                            $embedUrl = $videoUrl;
                        }
                    @endphp
                    
                    @if($embedUrl)
                        <iframe src="{{ $embedUrl }}?autoplay=0&rel=0&showinfo=0&modestbranding=1&controls=1" 
                                title="{{ $portfolio->title }} - Video Dokumentasi Pernikahan"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                loading="lazy">
                        </iframe>
                    @else
                        <div class="alert alert-warning text-center m-0">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>Video tidak dapat dimuat. Silakan cek kembali URL video.</p>
                            <small class="text-muted">URL: {{ $videoUrl }}</small>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4" data-aos="fade-left">
            <!-- Contact Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-gold text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i> Butuh Pernikahan Seperti Ini?</h5>
                </div>
                <div class="card-body">
                    <p>Wujudkan pernikahan impian Anda bersama Perfect Wedding.</p>
                    <a href="{{ route('contact') }}" class="btn btn-gold w-100">
                        <i class="fas fa-envelope me-2"></i> Konsultasi Gratis
                    </a>
                </div>
            </div>
            
            <!-- Related Portfolios -->
            @if($relatedPortfolios && count($relatedPortfolios) > 0)
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i> Portofolio Terkait</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedPortfolios as $related)
                    <div class="related-item mb-3 pb-3 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-4">
                                <img src="{{ asset('storage/' . $related->image) }}" 
                                     class="img-fluid rounded" 
                                     alt="{{ $related->title }}"
                                     style="height: 60px; width: 100%; object-fit: cover;">
                            </div>
                            <div class="col-8">
                                <a href="{{ route('portfolio.detail', ['id' => $related->id]) }}" 
                                   class="text-decoration-none">
                                    <h6 class="mb-1">{{ Str::limit($related->title, 40) }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i> 
                                        {{ $related->event_date->format('d M Y') }}
                                    </small>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('portfolio') }}" class="btn btn-outline-gold btn-sm">
                            Lihat Semua Portofolio
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal" style="z-index: 1051;"></button>
                <div id="lightboxCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="lightboxCarouselInner"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: #d4af37; }
    .bg-gold { background: linear-gradient(135deg, #d4af37, #c5a028); }
    .btn-outline-gold { border: 1px solid #d4af37; color: #d4af37; background: transparent; }
    .btn-outline-gold:hover { background: #d4af37; color: white; }
    
    .portfolio-video .ratio {
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    .portfolio-video iframe { width: 100%; height: 100%; border: none; }
    
    .gallery-item { overflow: hidden; cursor: pointer; }
    .gallery-item:hover img { transform: scale(1.1); }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
    
    .breadcrumb { background: none; padding: 0; }
    .breadcrumb-item a { color: #d4af37; text-decoration: none; }
    .breadcrumb-item a:hover { text-decoration: underline; }
    .breadcrumb-item.active { color: #6c757d; }
    
    .related-item { transition: transform 0.3s ease; }
    .related-item:hover { transform: translateX(5px); }
    
    .portfolio-main-image img { transition: transform 0.3s ease; }
    .portfolio-main-image img:hover { transform: scale(1.02); }
    
    @media (max-width: 768px) {
        .display-5 { font-size: 1.8rem; }
        .portfolio-meta { gap: 0.5rem; }
    }
</style>

@push('scripts')
<script>
    let galleryImages = @json($portfolio->gallery ?? []);
    
    function openLightbox(index) {
        const carouselInner = document.getElementById('lightboxCarouselInner');
        carouselInner.innerHTML = '';
        
        if (galleryImages.length === 0) return;
        
        galleryImages.forEach((image, idx) => {
            const activeClass = idx === index ? 'active' : '';
            const div = document.createElement('div');
            div.className = `carousel-item ${activeClass}`;
            div.innerHTML = `
                <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                    <img src="/storage/${image}" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
                </div>
            `;
            carouselInner.appendChild(div);
        });
        
        const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        modal.show();
    }
    
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