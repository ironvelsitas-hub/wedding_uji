<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - Perfect Wedding</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gold: #d4af37;
            --primary-gold-dark: #b8941f;
            --primary-gold-light: #f5e6b8;
            --primary-gold-soft: #fef8e7;
            --dark-bg: #1a1a2e;
            --sidebar-bg: #0f0f1a;
            --sidebar-hover: #1a1a2e;
            --content-bg: #f0f2f5;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition-fast: all 0.2s ease;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-size: 0.875rem;
            background-color: var(--content-bg);
            color: var(--text-primary);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* ==================== SIDEBAR STYLES ==================== */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 280px;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0a0a15 100%);
            box-shadow: var(--shadow-xl);
            transition: var(--transition);
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-280px);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: 100vh;
            padding-top: 1.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .sidebar-sticky::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: var(--primary-gold);
            border-radius: 10px;
        }

        /* Sidebar Navigation */
        .sidebar .nav {
            padding: 0 1rem;
        }

        .sidebar .nav-item {
            margin-bottom: 0.25rem;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            transition: var(--transition);
            border-radius: 12px;
            margin: 0.125rem 0;
            font-size: 0.875rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.1), transparent);
            transition: var(--transition);
            z-index: -1;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            width: 100%;
        }

        .sidebar .nav-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            color: var(--primary-gold);
            background: linear-gradient(90deg, rgba(212, 175, 55, 0.15), transparent);
            border-right: 3px solid var(--primary-gold);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar .nav-link .badge {
            float: right;
            margin-top: 2px;
        }

        /* Sidebar Toggle Button */
        .sidebar-toggle {
            position: fixed;
            left: 290px;
            top: 70px;
            z-index: 101;
            background: var(--primary-gold);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
        }

        .sidebar-toggle:hover {
            transform: scale(1.1);
        }

        .sidebar.collapsed + .sidebar-toggle {
            left: 20px;
        }

        .sidebar-toggle i {
            color: white;
            font-size: 14px;
        }

        /* ==================== NAVBAR STYLES ==================== */
        .navbar {
            background: var(--card-bg);
            box-shadow: var(--shadow-md);
            padding: 0;
            position: fixed;
            top: 0;
            right: 0;
            left: 280px;
            z-index: 99;
            transition: var(--transition);
        }

        .sidebar.collapsed ~ .navbar {
            left: 0;
        }

        .navbar-brand {
            padding: 1rem 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
            letter-spacing: 1px;
        }

        .navbar .nav-link {
            color: var(--text-secondary) !important;
            transition: var(--transition);
            padding: 1rem 1.25rem;
            position: relative;
        }

        .navbar .nav-link:hover {
            color: var(--primary-gold) !important;
            background-color: var(--primary-gold-soft);
        }

        /* Dropdown Animation */
        .dropdown-menu {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
            margin-top: 0.5rem;
            animation: fadeInDown 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
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

        .dropdown-item {
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            transition: var(--transition);
            border-radius: 12px;
        }

        .dropdown-item:hover {
            background-color: var(--primary-gold-soft);
            color: var(--primary-gold-dark);
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 24px;
            color: var(--primary-gold);
        }

        /* ==================== MAIN CONTENT ==================== */
        main {
            padding-top: 70px;
            margin-left: 280px;
            transition: var(--transition);
            min-height: 100vh;
        }

        .sidebar.collapsed ~ main {
            margin-left: 0;
        }

        /* ==================== CARD STYLES ==================== */
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            background: var(--card-bg);
            overflow: hidden;
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.5s ease-out;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .card-header.bg-gold {
            background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
            color: white;
            border: none;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ==================== BUTTON STYLES ==================== */
        .btn {
            border-radius: 12px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
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
            background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
            color: white;
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-outline-gold {
            border: 1px solid var(--primary-gold);
            color: var(--primary-gold);
            background: transparent;
        }

        .btn-outline-gold:hover {
            background: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            border-radius: 8px;
        }

        /* ==================== TABLE STYLES ==================== */
        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-gold-soft), #ffffff);
            color: var(--text-primary);
            font-weight: 600;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
            font-size: 0.85rem;
        }

        .table tbody td {
            padding: 0.875rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: var(--primary-gold-soft);
            transform: scale(1.01);
        }

        /* ==================== FORM STYLES ==================== */
        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 0.6rem 1rem;
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            outline: none;
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.85rem;
        }

        /* ==================== BADGE STYLES ==================== */
        .badge {
            font-size: 0.7rem;
            padding: 0.35rem 0.65rem;
            border-radius: 10px;
            font-weight: 500;
            animation: pulse 2s infinite;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #10b981, #059669) !important;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
        }

        /* ==================== PAGINATION ==================== */
        .pagination {
            margin-top: 1rem;
        }

        .pagination .page-link {
            border: none;
            color: var(--text-secondary);
            border-radius: 10px;
            margin: 0 3px;
            transition: var(--transition);
        }

        .pagination .page-link:hover {
            background-color: var(--primary-gold);
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active .page-link {
            background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark));
            color: white;
        }

        /* ==================== NOTIFICATION ==================== */
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1060;
            min-width: 320px;
            animation: slideInRight 0.3s ease-out;
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* ==================== STATS CARD ==================== */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 1.5rem;
            color: white;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: var(--transition);
        }

        .stats-card:hover::before {
            transform: rotate(45deg) scale(1.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
        }

        .stats-card .stats-icon {
            font-size: 2.5rem;
            opacity: 0.3;
            position: absolute;
            bottom: 1rem;
            right: 1rem;
        }

        .stats-card .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 1rem;
        }

        /* ==================== LOADING SKELETON ==================== */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 8px;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-280px);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .navbar {
                left: 0;
            }
            
            main {
                margin-left: 0;
                padding-top: 60px;
            }
            
            .notification {
                min-width: 280px;
                right: 10px;
                top: 70px;
            }
            
            .sidebar-toggle {
                display: none;
            }
        }

        /* ==================== UTILITY CLASSES ==================== */
        .text-gold {
            color: var(--primary-gold);
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--primary-gold), var(--primary-gold-dark)) !important;
        }

        .bg-gold-soft {
            background-color: var(--primary-gold-soft);
        }

        .shadow-hover {
            transition: var(--transition);
        }

        .shadow-hover:hover {
            box-shadow: var(--shadow-lg);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Fade In Animation */
        .fade-in {
            animation: fadeInUp 0.5s ease-out;
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
    </style>
</head>
<body>
    <!-- Sidebar Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-chevron-left"></i>
    </button>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-sticky">
            <div class="text-center mb-4">
                <div class="sidebar-logo">
                    <i class="fas fa-ring fa-2x text-gold"></i>
                    <h5 class="text-white mt-2">Perfect Wedding</h5>
                    <small class="text-muted">Admin Panel</small>
                </div>
            </div>
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                
                <!-- Layanan -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" 
                       href="{{ route('admin.services.index') }}">
                        <i class="fas fa-concierge-bell"></i>
                        Layanan
                    </a>
                </li>
                
                <!-- Paket Pernikahan -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" 
                       href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-gift"></i>
                        Paket Pernikahan
                    </a>
                </li>
                
                <!-- Portofolio -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}" 
                       href="{{ route('admin.portfolio.index') }}">
                        <i class="fas fa-images"></i>
                        Portofolio
                    </a>
                </li>
                
                <!-- Testimoni -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" 
                       href="{{ route('admin.testimonials.index') }}">
                        <i class="fas fa-star"></i>
                        Testimoni
                    </a>
                </li>
                
                <!-- Pesan Masuk -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}" 
                       href="{{ route('admin.inquiries.index') }}">
                        <i class="fas fa-envelope"></i>
                        Pesan Masuk
                        @php
                            try {
                                $unreadCount = App\Models\Inquiry::where('is_read', false)->count();
                            } catch (\Exception $e) {
                                $unreadCount = 0;
                            }
                        @endphp
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="badge bg-danger rounded-pill ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
                
                <!-- Profil Admin -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}" 
                       href="{{ route('admin.profile') }}">
                        <i class="fas fa-user"></i>
                        Profil Admin
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="navbar">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-ring me-2"></i> Perfect Wedding Admin
        </a>
        <div class="navbar-nav ms-auto me-3">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i> Admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="notification alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="notification alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('collapsed');
                const icon = sidebarToggle.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                }
            });
        }
        
        // Auto close notification after 5 seconds
        setTimeout(function() {
            $('.notification').fadeOut('slow');
        }, 5000);
        
        // Initialize DataTables
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                    },
                    pageLength: 10,
                    responsive: true,
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "→",
                            previous: "←"
                        }
                    }
                });
            }
        });
        
        // Confirm delete function
        window.confirmDelete = function() {
            return confirm('Apakah Anda yakin ingin menghapus data ini?');
        };
        
        // Add animation to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.05}s`;
            });
            
            // Active menu highlight
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && href !== '#' && currentPath.includes(href)) {
                    link.classList.add('active');
                }
            });
        });
        
        // Smooth scroll to top
        window.addEventListener('scroll', function() {
            const scrollTop = document.querySelector('.scroll-top');
            if (scrollTop) {
                if (window.pageYOffset > 100) {
                    scrollTop.classList.add('show');
                } else {
                    scrollTop.classList.remove('show');
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>