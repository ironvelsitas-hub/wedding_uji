@extends('layouts.app')

@section('title', 'Perfect Wedding - Wedding Organizer Terbaik')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-3 fw-bold mb-4 fade-in-up">Mewujudkan Pernikahan Impian Anda</h1>
                <p class="lead mb-4 fade-in-up">Kami hadir untuk membuat hari spesial Anda menjadi tak terlupakan dengan pelayanan profesional dan detail yang sempurna.</p>
                <a href="{{ route('contact') }}" class="btn btn-gold btn-lg fade-in-up">Konsultasi Gratis</a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Layanan Kami</h2>
        <div class="row">
            @foreach($services as $service)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="service-card text-center p-4">
                    <i class="{{ $service->icon }} fa-3x mb-3" style="color: #d4af37;"></i>
                    <h4>{{ $service->name }}</h4>
                    <p>{{ $service->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Packages Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Paket Pernikahan</h2>
        <div class="row">
            @foreach($packages as $package)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="package-card card h-100">
                    @if($package->is_popular)
                    <div class="card-header text-center bg-gold text-white">Paling Populer</div>
                    @endif
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ $package->name }}</h3>
                        <h2 class="text-gold">Rp {{ number_format($package->price, 0, ',', '.') }}</h2>
                        <ul class="list-unstyled mt-3">
                            @foreach($package->features as $feature)
                            <li class="mb-2"><i class="fas fa-check text-gold me-2"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('contact') }}" class="btn btn-gold mt-3">Pilih Paket</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Galeri Pernikahan</h2>
        <div class="row">
            @foreach($portfolios as $portfolio)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="portfolio-card">
                    <img src="{{ asset('storage/' . $portfolio->image) }}" class="img-fluid rounded" alt="{{ $portfolio->title }}">
                    <div class="mt-2">
                        <h5>{{ $portfolio->title }}</h5>
                        <p class="text-muted">{{ $portfolio->event_date->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('portfolio') }}" class="btn btn-gold">Lihat Semua</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Kata Mereka</h2>
        <div class="row">
            @foreach($testimonials as $testimonial)
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="testimonial-card">
                    <div class="mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $testimonial->rating)
                                <i class="fas fa-star text-warning"></i>
                            @else
                                <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                    </div>
                    <p class="mb-3">"{{ $testimonial->message }}"</p>
                    <div class="d-flex align-items-center">
                        @if($testimonial->photo)
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" class="rounded-circle me-3" width="50" height="50">
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $testimonial->client_name }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection