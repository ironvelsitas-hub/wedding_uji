<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Wedding Organizer') - Perfect Wedding</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
:root {
    --primary-gold: #c5a059;
    --primary-gold-dark: #a37f3d;
    --primary-gold-light: #e2cf9b;
    --primary-gold-soft: #faf6eb;
    --dark-bg: #0f172a;
    --darker-bg: #020617;
    --light-bg: #f8fafc;
    --text-dark: #0f172a;
    --text-light: #475569;
    --text-muted: #94a3b8;
    --white: #ffffff;
    --shadow-sm: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 20px -2px rgb(0 0 0 / 0.08);
    --shadow-lg: 0 10px 30px -5px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
    --transition-fast: all 0.2s ease;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: all 0.5s ease;
    --border-radius-sm: 10px;
    --border-radius-md: 16px;
    --border-radius-lg: 24px;
    --border-radius-xl: 30px;
    --border-radius-full: 9999px;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    color: var(--text-dark);
    background-color: var(--light-bg);
    overflow-x: hidden;
    line-height: 1.7;
    scroll-behavior: smooth;
    min-height: 100vh;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    letter-spacing: -0.02em;
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(40px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes zoomIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.05);
    }
}

@keyframes shimmer {
    0% {
        background-position: -1000px 0;
    }
    100% {
        background-position: 1000px 0;
    }
}

@keyframes rotate {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

@keyframes borderGlow {
    0%, 100% {
        border-color: rgba(212, 175, 55, 0.3);
        box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.2);
    }
    50% {
        border-color: rgba(212, 175, 55, 0.8);
        box-shadow: 0 0 20px 0 rgba(212, 175, 55, 0.4);
    }
}

/* Animation Classes */
.fade-in-up {
    animation: fadeInUp 0.8s ease-out forwards;
}

.fade-in-down {
    animation: fadeInDown 0.8s ease-out forwards;
}

.fade-in-left {
    animation: fadeInLeft 0.8s ease-out forwards;
}

.fade-in-right {
    animation: fadeInRight 0.8s ease-out forwards;
}

.zoom-in {
    animation: zoomIn 0.5s ease-out forwards;
}

.float-animation {
    animation: float 3s ease-in-out infinite;
}

.pulse-animation {
    animation: pulse 2s ease-in-out infinite;
}

/* Staggered Animations */
.stagger-item {
    opacity: 0;
}

.stagger-1 { animation: fadeInUp 0.5s ease-out 0.1s forwards; }
.stagger-2 { animation: fadeInUp 0.5s ease-out 0.2s forwards; }
.stagger-3 { animation: fadeInUp 0.5s ease-out 0.3s forwards; }
.stagger-4 { animation: fadeInUp 0.5s ease-out 0.4s forwards; }
.stagger-5 { animation: fadeInUp 0.5s ease-out 0.5s forwards; }

/* ==================== NAVBAR STYLES ==================== */
.navbar {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    padding: 16px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}

.navbar.scrolled {
    background: white;
    box-shadow: var(--shadow-md);
    padding: 10px 0;
    backdrop-filter: blur(12px);
}

.navbar-brand {
    font-size: 1.6rem;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent !important;
    letter-spacing: -0.5px;
    position: relative;
    transition: var(--transition);
}

.navbar-brand:hover {
    transform: scale(1.02);
}

.navbar-brand::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-gold), transparent);
    transition: var(--transition);
}

.navbar-brand:hover::after {
    width: 100%;
}

.nav-link {
    font-weight: 600;
    color: var(--text-dark) !important;
    transition: var(--transition);
    position: relative;
    padding: 5px 0;
    margin: 0 12px;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.nav-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-gold), var(--primary-gold-dark));
    transition: var(--transition);
    transform: translateX(-50%);
    border-radius: var(--border-radius-full);
}

.nav-link:hover::before,
.nav-link.active::before {
    width: 80%;
}

.nav-link:hover {
    color: var(--primary-gold) !important;
}

/* Dropdown Menu */
.dropdown-menu {
    border: none;
    border-radius: var(--border-radius-md);
    box-shadow: var(--shadow-lg);
    padding: 12px 0;
    margin-top: 12px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(212, 175, 55, 0.1);
}

.dropdown-item {
    padding: 10px 24px;
    font-size: 0.9rem;
    transition: var(--transition);
    color: var(--text-dark);
    position: relative;
    overflow: hidden;
}

.dropdown-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(90deg, var(--primary-gold-light), transparent);
    transition: var(--transition);
    z-index: -1;
}

.dropdown-item:hover::before {
    width: 100%;
}

.dropdown-item:hover {
    color: var(--primary-gold-dark);
    padding-left: 32px;
}

.dropdown-item i {
    width: 24px;
    color: var(--primary-gold);
    transition: var(--transition);
}

.dropdown-item:hover i {
    transform: translateX(5px);
}

/* ==================== HERO SECTION ==================== */
.hero {
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    height: 100vh;
    display: flex;
    align-items: center;
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
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
}

.hero::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 150px;
    background: linear-gradient(to top, var(--light-bg), transparent);
    z-index: 2;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 3;
}

.hero h1 {
    font-size: 4rem;
    text-shadow: 0 10px 30px rgba(0,0,0,0.5);
    color: white;
    letter-spacing: -1px;
}

.hero .lead {
    font-size: 1.25rem;
    margin-bottom: 30px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.hero .btn-gold {
    animation: fadeInUp 0.8s ease-out 0.4s both;
    position: relative;
    overflow: hidden;
}

.hero .btn-gold::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.hero .btn-gold:active::after {
    width: 300px;
    height: 300px;
}

/* ==================== BUTTON STYLES ==================== */
.btn {
    border-radius: var(--border-radius-md);
    padding: 14px 36px;
    font-weight: 500;
    transition: var(--transition);
    cursor: pointer;
    position: relative;
    overflow: hidden;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-size: 0.85rem;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: var(--transition);
}

.btn:hover::before {
    left: 100%;
}

.btn-gold {
    background: linear-gradient(135deg, var(--primary-gold) 0%, var(--primary-gold-dark) 100%);
    color: white;
    border: none;
    box-shadow: 0 10px 20px -5px rgba(197, 160, 89, 0.4);
}

.btn-gold:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px -5px rgba(197, 160, 89, 0.5);
    color: white;
}

.btn-outline-gold {
    border: 2px solid var(--primary-gold);
    background: transparent;
    color: var(--primary-gold);
    transition: var(--transition);
}

.btn-outline-gold:hover {
    background: var(--primary-gold);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}

/* ==================== SECTION TITLE ==================== */
.section-title {
    font-size: 2.8rem;
    position: relative;
    padding-bottom: 25px;
    color: var(--text-dark);
    margin-bottom: 50px;
    text-align: center;
    font-weight: 800;
}

.section-title::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--primary-gold);
    border-radius: var(--border-radius-full);
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -14px;
    left: 50%;
    transform: translateX(-50%) rotate(45deg);
    width: 10px;
    height: 10px;
    background: var(--primary-gold-light);
    border: 2px solid var(--primary-gold);
    z-index: 2;
}

/* ==================== CARD STYLES ==================== */
.service-card, .package-card, .portfolio-card {
    transition: var(--transition);
    margin-bottom: 30px;
    border-radius: var(--border-radius-md);
    overflow: hidden;
    background: #fff;
    border: none;
    box-shadow: var(--shadow-sm);
    position: relative;
}

.service-card::before, .package-card::before, .portfolio-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.05), transparent);
    opacity: 0;
    transition: var(--transition);
    pointer-events: none;
    z-index: 1;
}

.service-card:hover::before, .package-card:hover::before, .portfolio-card:hover::before {
    opacity: 1;
}

.service-card:hover, .package-card:hover, .portfolio-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 30px 60px -12px rgba(0,0,0,0.15);
}

.testimonial-card {
    background: white;
    border-radius: var(--border-radius-lg);
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    border: 1px solid rgba(212, 175, 55, 0.1);
    position: relative;
    overflow: hidden;
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    bottom: -20px;
    right: 10px;
    font-size: 100px;
    color: rgba(212, 175, 55, 0.1);
    font-family: serif;
}

.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-gold);
}

/* ==================== PORTFOLIO OVERLAY ==================== */
.portfolio-image-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: var(--border-radius-md);
}

.portfolio-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.9), rgba(184, 148, 31, 0.9));
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: var(--transition);
    transform: scale(0.9);
}

.portfolio-image-wrapper:hover .portfolio-overlay {
    opacity: 1;
    transform: scale(1);
}

.portfolio-overlay-content {
    text-align: center;
    color: white;
    transform: translateY(20px);
    transition: var(--transition);
}

.portfolio-image-wrapper:hover .portfolio-overlay-content {
    transform: translateY(0);
}

.portfolio-img {
    transition: var(--transition);
}

.portfolio-image-wrapper:hover .portfolio-img {
    transform: scale(1.1);
}

/* ==================== FOOTER STYLES ==================== */
.footer {
    background: linear-gradient(135deg, var(--darker-bg) 0%, var(--dark-bg) 100%);
    color: var(--text-muted);
    padding: 70px 0 30px;
    position: relative;
}

.footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, var(--primary-gold), var(--primary-gold-dark), transparent);
}

.footer h5 {
    color: white;
    margin-bottom: 20px;
    font-size: 1.2rem;
    position: relative;
    display: inline-block;
}

.footer h5::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 40px;
    height: 2px;
    background: var(--primary-gold);
    border-radius: var(--border-radius-full);
}

.social-icons a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    transition: var(--transition);
    margin: 0 6px;
    position: relative;
    overflow: hidden;
}

.social-icons a::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--primary-gold);
    transform: scale(0);
    transition: var(--transition);
    border-radius: 50%;
}

.social-icons a:hover::before {
    transform: scale(1);
}

.social-icons a i {
    position: relative;
    z-index: 1;
    transition: var(--transition);
}

.social-icons a:hover i {
    color: white;
}

.social-icons a:hover {
    transform: translateY(-3px);
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 1200px) {
    .hero h1 {
        font-size: 3.5rem;
    }
}

@media (max-width: 992px) {
    .hero h1 {
        font-size: 3rem;
    }
    
    .section-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 768px) {
    .hero {
        background-attachment: scroll;
    }
    
    .hero h1 {
        font-size: 2rem;
    }
    
    .hero .lead {
        font-size: 1rem;
    }
    
    .section-title {
        font-size: 1.8rem;
        margin-bottom: 40px;
    }
    
    .navbar-brand {
        font-size: 1.4rem;
    }
    
    .nav-link {
        margin: 10px 0;
    }
    
    .dropdown-menu {
        border: none;
        background: transparent;
        box-shadow: none;
        padding-left: 20px;
    }
    
    .dropdown-item:hover {
        padding-left: 20px;
    }
    
    .footer {
        text-align: center;
    }
    
    .social-icons {
        justify-content: center;
        display: flex;
        margin-top: 20px;
    }
    
    .footer h5::after {
        left: 50%;
        transform: translateX(-50%);
    }
}

@media (max-width: 576px) {
    .hero h1 {
        font-size: 1.8rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .btn-gold, .btn-outline-gold {
        padding: 8px 24px;
        font-size: 0.9rem;
    }
}

/* ==================== UTILITY CLASSES ==================== */
.text-gold {
    color: var(--primary-gold);
}

.bg-gold {
    background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
}

.bg-gold-soft {
    background: var(--primary-gold-soft);
}

.shadow-hover {
    transition: var(--transition);
}

.shadow-hover:hover {
    box-shadow: var(--shadow-lg);
}

/* Loading Spinner */
.loading-spinner {
    width: 40px;
    height: 40px;
    border: 3px solid rgba(212, 175, 55, 0.2);
    border-top-color: var(--primary-gold);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: var(--light-bg);
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
    border-radius: var(--border-radius-full);
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, var(--primary-gold-dark), #a07c1a);
}

/* Selection */
::selection {
    background: var(--primary-gold);
    color: white;
}

/* Focus */
:focus-visible {
    outline: 2px solid var(--primary-gold);
    outline-offset: 2px;
    border-radius: var(--border-radius-sm);
}
</style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">✦ Perfect Wedding</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('services') || request()->routeIs('packages') ? 'active' : '' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                            Layanan
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('services') }}"><i class="fas fa-concierge-bell me-2"></i> Layanan Kami</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('packages') }}"><i class="fas fa-gift me-2"></i> Paket Pernikahan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portofolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('testimonials') ? 'active' : '' }}" href="{{ route('testimonials') }}">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i> Poin Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
@else
<li class="nav-item">
    <a class="nav-link" href="{{ route('login') }}">
        <i class="fas fa-sign-in-alt me-1"></i> Login
    </a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('register') }}">
        <i class="fas fa-user-plus me-1"></i> Daftar
    </a>
</li>
@endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">Perfect Wedding</h5>
                    <p>Mewujudkan pernikahan impian Anda dengan pelayanan terbaik dan profesional.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">Kontak</h5>
                    <p><i class="fas fa-map-marker-alt me-2 text-gold"></i> Jl. Kebahagiaan No. 123, Jakarta</p>
                    <p><i class="fas fa-phone me-2 text-gold"></i> (021) 1234-5678</p>
                    <p><i class="fas fa-envelope me-2 text-gold"></i> info@perfectwedding.com</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="text-white mb-3">Jam Operasional</h5>
                    <p><i class="far fa-clock me-2 text-gold"></i> Senin - Jumat: 09:00 - 18:00</p>
                    <p class="ms-4">Sabtu: 10:00 - 15:00</p>
                    <p class="ms-4 text-muted">Minggu: Tutup</p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Perfect Wedding. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // ==================== LOGIN SYSTEM ====================
        
        // Fungsi untuk menampilkan modal login
        window.showLoginModal = function() {
            fetch('/login-modal')
                .then(res => res.text())
                .then(html => {
                    const oldModal = document.getElementById('loginModal');
                    if (oldModal) oldModal.remove();
                    
                    document.body.insertAdjacentHTML('beforeend', html);
                    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                    modal.show();
                    
                    // Simpan URL redirect setelah login
                    localStorage.setItem('redirect_after_login', window.location.pathname);
                });
        }
        
        // Cek login status sebelum memilih paket
        window.checkLoginAndSelectPackage = function(packageName) {
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
                    fetch('/login-modal')
                        .then(res => res.text())
                        .then(html => {
                            const oldModal = document.getElementById('loginModal');
                            if (oldModal) oldModal.remove();
                            
                            document.body.insertAdjacentHTML('beforeend', html);
                            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
                            modal.show();
                            
                            localStorage.setItem('selected_package', packageName);
                        });
                }
            })
            .catch(error => {
                console.error('Error checking login:', error);
                window.location.href = `/contact?package=${encodeURIComponent(packageName)}`;
            });
        }
        
        // Fungsi untuk menutup modal
        window.closeLoginModal = function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (modal) modal.hide();
        }
        
        // Add active class to current nav link
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath === href) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>