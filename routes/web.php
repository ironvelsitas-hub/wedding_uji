<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserTestimonialController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== ROUTE FRONTEND ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// ==================== LAYANAN & PAKET ROUTES ====================
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/packages', [HomeController::class, 'packages'])->name('packages');

// ==================== PORTOFOLIO ROUTES ====================
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{id}/{slug?}', [HomeController::class, 'portfolioDetail'])->name('portfolio.detail');

// ==================== TESTIMONI & KONTAK ROUTES ====================
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::post('/testimonial/submit', [UserTestimonialController::class, 'store'])->name('testimonial.submit');

// ==================== CHAT ROUTES (FRONTEND) ====================
Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
Route::get('/chat/check', [ChatController::class, 'checkStatus'])->name('chat.check');
Route::get('/chat/history', [ChatController::class, 'getHistory'])->name('chat.history');
Route::post('/chat/identity', [ChatController::class, 'saveIdentity'])->name('chat.identity');

// ==================== ROUTE ADMIN PANEL ====================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // ==================== GUEST ROUTES (BELUM LOGIN) ====================
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });
    
    // ==================== LOGOUT ROUTE ====================
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // ==================== PROTECTED ROUTES (HARUS LOGIN) ====================
    Route::middleware('admin.auth')->group(function () {
        
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Services
        Route::resource('services', ServiceController::class);
        
        // Manajemen Packages
        Route::resource('packages', PackageController::class);
        
        // Manajemen Portfolio
        Route::resource('portfolio', PortfolioController::class);
        Route::patch('portfolio/{portfolio}/toggle-featured', [PortfolioController::class, 'toggleFeatured'])->name('portfolio.toggle-featured');
        
        // Manajemen Testimonials
        Route::resource('testimonials', TestimonialController::class);
        Route::patch('testimonials/{testimonial}/status', [TestimonialController::class, 'updateStatus'])->name('testimonials.status');
        Route::patch('testimonials/{testimonial}/toggle-featured', [TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
        Route::patch('testimonials/{testimonial}/verify', [TestimonialController::class, 'verify'])->name('testimonials.verify');
        
        // Manajemen Inquiries (Pesan Masuk)
        Route::prefix('inquiries')->name('inquiries.')->group(function () {
            Route::get('/', [AdminInquiryController::class, 'index'])->name('index');
            Route::get('/{inquiry}', [AdminInquiryController::class, 'show'])->name('show');
            Route::delete('/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('destroy');
            Route::patch('/{inquiry}/read', [AdminInquiryController::class, 'markAsRead'])->name('read');
        });
        
        // Profil Admin
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        
    });
});

// ==================== AUTH ROUTES (FRONTEND USER) ====================
Route::controller(LoginController::class)->group(function () {
    // Halaman Login dan Register
    Route::get('/login', 'showLoginPage')->name('login');
    Route::get('/register', 'showRegisterPage')->name('register');
    
    // Modal dan API
    Route::get('/login-modal', 'showLoginForm')->name('login.modal');
    Route::post('/login/email', 'loginWithEmail')->name('login.email');
    Route::post('/login/phone', 'loginWithPhone')->name('login.phone');
    Route::post('/send-otp', 'sendOtp')->name('send.otp');
    Route::get('/login/facebook', 'redirectToFacebook')->name('login.facebook');
    Route::get('/login/facebook/callback', 'handleFacebookCallback')->name('login.facebook.callback');
    Route::post('/register', 'register')->name('register');
    Route::post('/logout', 'logout')->name('logout');
});

// ==================== CHECK LOGIN STATUS ====================
Route::get('/check-login', function() {
    return response()->json(['logged_in' => Auth::check()]);
})->name('check.login');