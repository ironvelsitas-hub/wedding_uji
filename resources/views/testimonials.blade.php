@extends('layouts.app')

@section('title', 'Testimoni - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <!-- Header -->
    <div class="text-center mb-5" data-aos="fade-up">
        <h2 class="section-title">💬 Testimoni Klien 💬</h2>
        <p class="text-muted">Apa kata mereka tentang layanan kami</p>
    </div>
    
    <!-- Statistik -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-primary text-white border-0 shadow">
                <div class="card-body">
                    <h2 class="mb-0">{{ $testimonials->total() }}</h2>
                    <p class="mb-0">Total Testimoni</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-success text-white border-0 shadow">
                <div class="card-body">
                    <h2 class="mb-0">{{ number_format($averageRating, 1) }}</h2>
                    <p class="mb-0">Rating Rata-rata</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-info text-white border-0 shadow">
                <div class="card-body">
                    <h2 class="mb-0">{{ $fiveStarCount }}</h2>
                    <p class="mb-0">Testimoni 5 Bintang</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center bg-warning text-white border-0 shadow">
                <div class="card-body">
                    <h2 class="mb-0">
                        @for($i = 1; $i <= floor($averageRating); $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @if($averageRating - floor($averageRating) >= 0.5)
                            <i class="fas fa-star-half-alt"></i>
                        @endif
                    </h2>
                    <p class="mb-0">Kepuasan Klien</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12 text-center">
            <div class="btn-group flex-wrap">
                <button class="btn btn-outline-gold filter-btn active" data-filter="all">Semua</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="5">★ 5 Bintang</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="featured">Featured</button>
                <button class="btn btn-outline-gold filter-btn" data-filter="video">Dengan Video</button>
            </div>
        </div>
    </div>
    
    <!-- Testimoni List -->
    <div class="row" id="testimonial-container">
        @foreach($testimonials as $testimonial)
        <div class="col-md-6 mb-4 testimonial-item" 
             data-rating="{{ $testimonial->rating }}"
             data-featured="{{ $testimonial->is_featured ? 'true' : 'false' }}"
             data-video="{{ $testimonial->video_url ? 'true' : 'false' }}"
             data-aos="fade-up">
            <div class="testimonial-card-modern h-100">
                <div class="d-flex align-items-start mb-3">
                    <div class="testimonial-avatar me-3">
                        @if($testimonial->photo)
                            <img src="{{ asset('storage/' . $testimonial->photo) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-0">{{ $testimonial->client_name }}</h5>
                                @if($testimonial->couple_name)
                                    <small class="text-muted">{{ $testimonial->couple_name }}</small>
                                @endif
                            </div>
                            @if($testimonial->is_featured)
                                <span class="badge bg-warning"><i class="fas fa-star"></i> Featured</span>
                            @endif
                        </div>
                        <div class="rating mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="testimonial-content">
                    <i class="fas fa-quote-left quote-icon"></i>
                    <p class="mb-3">{{ $testimonial->message }}</p>
                    @if($testimonial->wedding_date)
                        <small class="text-muted"><i class="fas fa-calendar-alt me-1"></i> {{ date('d F Y', strtotime($testimonial->wedding_date)) }}</small>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $testimonials->links() }}
    </div>
    
    <!-- Form Berikan Ulasan -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-gold text-white text-center py-3 rounded-top-4">
                    <h4 class="mb-0"><i class="fas fa-star me-2"></i> Berikan Ulasan Anda</h4>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted text-center mb-4">Bagikan pengalaman Anda menggunakan layanan Perfect Wedding. Ulasan Anda akan sangat berarti bagi kami.</p>
                    
                    <form id="testimonial-form" action="{{ route('testimonial.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="testimonial_name" name="client_name" required>
                                <div class="invalid-feedback" id="testimonial_name_error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="testimonial_email" name="email" required>
                                <div class="invalid-feedback" id="testimonial_email_error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="testimonial_phone" name="phone" required>
                                <div class="invalid-feedback" id="testimonial_phone_error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pernikahan</label>
                                <input type="date" class="form-control" id="testimonial_wedding_date" name="wedding_date">
                                <div class="invalid-feedback" id="testimonial_wedding_date_error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <div class="rating-input">
                                    <div class="stars">
                                        <i class="far fa-star" data-value="1"></i>
                                        <i class="far fa-star" data-value="2"></i>
                                        <i class="far fa-star" data-value="3"></i>
                                        <i class="far fa-star" data-value="4"></i>
                                        <i class="far fa-star" data-value="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" id="testimonial_rating" required>
                                </div>
                                <div class="invalid-feedback" id="testimonial_rating_error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Ulasan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="testimonial_message" name="message" rows="4" placeholder="Ceritakan pengalaman Anda menggunakan layanan Perfect Wedding..." required></textarea>
                                <div class="invalid-feedback" id="testimonial_message_error"></div>
                            </div>
                            <div class="col-12 mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="testimonial_consent" required>
                                <label class="form-check-label">
                                    Saya menyetujui bahwa ulasan ini dapat ditampilkan di website Perfect Wedding
                                </label>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-gold px-5" id="testimonial_submit_btn">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Ulasan Anda akan kami verifikasi terlebih dahulu sebelum ditampilkan di halaman ini.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline-gold {
        border: 2px solid #d4af37;
        color: #d4af37;
        margin: 5px;
        transition: all 0.3s ease;
    }
    .btn-outline-gold:hover, .btn-outline-gold.active {
        background-color: #d4af37;
        color: white;
    }
    
    .testimonial-card-modern {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .testimonial-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(212, 175, 55, 0.12);
    }
    
    .quote-icon {
        position: absolute;
        bottom: 20px;
        right: 20px;
        font-size: 50px;
        color: rgba(212, 175, 55, 0.1);
        z-index: 0;
    }
    
    .testimonial-content {
        position: relative;
        z-index: 1;
    }
    
    .rating {
        font-size: 0.9rem;
    }
    
    /* Star Rating Input */
    .rating-input .stars {
        display: flex;
        gap: 10px;
        cursor: pointer;
    }
    .rating-input .stars i {
        font-size: 30px;
        color: #ddd;
        transition: all 0.3s ease;
    }
    .rating-input .stars i:hover,
    .rating-input .stars i.active {
        color: #ffc107;
    }
    
    .bg-gold {
        background: linear-gradient(135deg, #d4af37, #c5a028);
    }
    
    .rounded-4 {
        border-radius: 20px;
    }
    
    .rounded-top-4 {
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .rating-input .stars i {
            font-size: 24px;
        }
    }
</style>

<script>
// Filter testimonials
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelectorAll('.testimonial-item').forEach(item => {
            let show = true;
            if (filter === 'all') show = true;
            else if (filter === 'featured') show = item.dataset.featured === 'true';
            else if (filter === 'video') show = item.dataset.video === 'true';
            else if (filter === '5') show = item.dataset.rating === '5';
            item.style.display = show ? 'block' : 'none';
        });
    });
});

// Star Rating Input
const stars = document.querySelectorAll('.rating-input .stars i');
const ratingInput = document.getElementById('testimonial_rating');

stars.forEach(star => {
    star.addEventListener('mouseenter', function() {
        const value = parseInt(this.dataset.value);
        stars.forEach((s, index) => {
            if (index < value) {
                s.classList.remove('far');
                s.classList.add('fas');
            } else {
                s.classList.remove('fas');
                s.classList.add('far');
            }
        });
    });
    
    star.addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        stars.forEach((s, index) => {
            if (index < currentRating) {
                s.classList.remove('far');
                s.classList.add('fas');
            } else {
                s.classList.remove('fas');
                s.classList.add('far');
            }
        });
    });
    
    star.addEventListener('click', function() {
        const value = parseInt(this.dataset.value);
        ratingInput.value = value;
        stars.forEach((s, index) => {
            if (index < value) {
                s.classList.remove('far');
                s.classList.add('fas');
                s.classList.add('active');
            } else {
                s.classList.remove('fas');
                s.classList.add('far');
                s.classList.remove('active');
            }
        });
    });
});

// Form submission
document.getElementById('testimonial-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('testimonial_submit_btn');
    const originalText = submitBtn.innerHTML;
    
    // Reset errors
    document.querySelectorAll('#testimonial-form .is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('#testimonial-form .invalid-feedback').forEach(el => el.classList.remove('show'));
    
    // Validate rating
    if (!ratingInput.value) {
        document.getElementById('testimonial_rating_error').textContent = 'Silakan pilih rating';
        document.getElementById('testimonial_rating_error').classList.add('show');
        return;
    }
    
    // Validate consent
    const consent = document.getElementById('testimonial_consent');
    if (!consent.checked) {
        alert('Anda harus menyetujui ketentuan untuk mengirim ulasan');
        return;
    }
    
    const formData = new FormData(this);
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            alert(data.message);
            this.reset();
            ratingInput.value = '';
            stars.forEach(s => {
                s.classList.remove('fas', 'active');
                s.classList.add('far');
            });
        } else if (response.status === 422 && data.errors) {
            for (const [field, messages] of Object.entries(data.errors)) {
                const errorDiv = document.getElementById(`testimonial_${field}_error`);
                const input = document.getElementById(`testimonial_${field}`);
                if (errorDiv) {
                    errorDiv.textContent = messages[0];
                    errorDiv.classList.add('show');
                }
                if (input) input.classList.add('is-invalid');
            }
        } else {
            alert(data.message || 'Gagal mengirim ulasan');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});
</script>
@endsection