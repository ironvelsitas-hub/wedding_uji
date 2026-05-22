@extends('layouts.app')

@section('title', 'Portofolio - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <h2 class="section-title" data-aos="fade-up">Portofolio Pernikahan</h2>
    
    <!-- Filter kategori -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12 text-center">
            <div class="btn-group flex-wrap">
                <button class="btn btn-outline-gold filter-btn active" data-filter="all">Semua</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="wedding">Pernikahan</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="engagement">Tunangan</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="prewedding">Pre-wedding</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="reception">Resepsi</button>
            </div>
        </div>
    </div>
    
    <div class="row" id="portfolio-container">
        @foreach($portfolios as $portfolio)
        <!-- Di dalam loop portfolio, ubah link menuju detail -->
        <div class="col-md-4 mb-4 portfolio-item" data-category="{{ $portfolio->category }}" data-aos="fade-up">
            <div class="portfolio-card">
                <a href="{{ route('portfolio.detail', ['id' => $portfolio->id]) }}" class="text-decoration-none">
                    <div class="position-relative overflow-hidden rounded">
                        <img src="{{ asset('storage/' . $portfolio->image) }}" 
                             class="img-fluid w-100" 
                             alt="{{ $portfolio->title }}"
                             style="height: 300px; object-fit: cover; transition: transform 0.3s;">
                        
                        @if($portfolio->is_featured)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-warning">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </div>
                    <div class="mt-3">
                        <h5 class="text-dark">{{ $portfolio->title }}</h5>
                        <p class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $portfolio->event_date->format('d F Y') }}
                        </p>
                        <p class="text-dark">{{ Str::limit($portfolio->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-info">{{ ucfirst($portfolio->category) }}</span>
                            @if($portfolio->gallery)
                                <small class="text-muted">
                                    <i class="fas fa-images"></i> {{ count($portfolio->gallery) }} foto
                                </small>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $portfolios->links() }}
    </div>
</div>

<style>
    .btn-outline-gold {
        border: 2px solid #d4af37;
        color: #d4af37;
        margin: 5px;
        transition: all 0.3s ease;
    }
    
    .btn-outline-gold:hover,
    .btn-outline-gold.active {
        background-color: #d4af37;
        color: white;
    }
    
    .portfolio-card {
        overflow: hidden;
        transition: transform 0.3s ease;
        border-radius: 10px;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .portfolio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .position-relative {
        overflow: hidden;
    }
    
    .portfolio-card:hover img {
        transform: scale(1.1);
    }
    
    a.text-decoration-none:hover h5 {
        color: #d4af37 !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .btn-outline-gold {
            font-size: 0.9rem;
            padding: 5px 12px;
        }
    }
</style>

@push('scripts')
<script>
// Filter portfolio
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Filter items with animation
        document.querySelectorAll('.portfolio-item').forEach(item => {
            if (filter === 'all' || item.dataset.category === filter) {
                item.style.display = 'block';
                item.style.animation = 'fadeInUp 0.5s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// Add fade in animation
const style = document.createElement('style');
style.textContent = `
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
`;
document.head.appendChild(style);
</script>
@endpush
@endsection