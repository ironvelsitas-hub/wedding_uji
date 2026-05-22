<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Perfect Wedding</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            max-width: 450px;
            margin: 0 auto;
        }
        .login-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            background: white;
        }
        .login-header {
            background: linear-gradient(135deg, #d4af37, #c5a028);
            padding: 30px;
            text-align: center;
        }
        .login-header i {
            font-size: 60px;
            color: white;
            margin-bottom: 15px;
        }
        .login-header h3 {
            color: white;
            margin-bottom: 5px;
        }
        .login-body {
            padding: 40px;
        }
        .btn-gold {
            background: #d4af37;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            background: #c5a028;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #d4af37;
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        .text-gold {
            color: #d4af37;
        }
        .nav-tabs .nav-link {
            color: #666;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #d4af37;
            border-bottom: 2px solid #d4af37;
            background: transparent;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <i class="fas fa-ring"></i>
                    <h3>Perfect Wedding</h3>
                    <p class="mb-0 text-white-50">Login ke akun Anda</p>
                </div>
                <div class="login-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs mb-4 justify-content-center" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-login" type="button">
                                <i class="fas fa-envelope me-1"></i> Email
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone-login" type="button">
                                <i class="fas fa-phone me-1"></i> Telepon
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="facebook-tab" data-bs-toggle="tab" data-bs-target="#facebook-login" type="button">
                                <i class="fab fa-facebook me-1"></i> Facebook
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <!-- Login with Email -->
                        <div class="tab-pane fade show active" id="email-login">
                            <form id="loginEmailForm">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="loginEmail" required>
                                    <div class="invalid-feedback" id="loginEmailError"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" id="loginPassword" required>
                                    <div class="invalid-feedback" id="loginPasswordError"></div>
                                </div>
                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </form>
                        </div>
                        
                        <!-- Login with Phone -->
                        <div class="tab-pane fade" id="phone-login">
                            <form id="loginPhoneForm">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="loginPhoneNumber" placeholder="08123456789" required>
                                    <div class="invalid-feedback" id="loginPhoneError"></div>
                                </div>
                                <div id="otpSection" style="display: none;">
                                    <div class="mb-3">
                                        <label class="form-label">Kode OTP</label>
                                        <input type="text" class="form-control" id="loginOtp" maxlength="6">
                                        <div class="invalid-feedback" id="loginOtpError"></div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-gold w-100" id="sendOtpBtn">
                                    <i class="fas fa-paper-plane me-2"></i> Kirim OTP
                                </button>
                                <button type="submit" class="btn btn-gold w-100 mt-2" id="verifyOtpBtn" style="display: none;">
                                    <i class="fas fa-check-circle me-2"></i> Verifikasi & Login
                                </button>
                            </form>
                        </div>
                        
                        <!-- Login with Facebook -->
                        <div class="tab-pane fade" id="facebook-login">
                            <div class="text-center py-4">
                                <i class="fab fa-facebook fa-4x text-primary mb-3"></i>
                                <p>Login dengan akun Facebook Anda</p>
                                <a href="{{ route('login.facebook') }}" class="btn btn-primary">
                                    <i class="fab fa-facebook me-2"></i> Login dengan Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-gold fw-bold">Daftar Sekarang</a>
                        </p>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Login with Email
        document.getElementById('loginEmailForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            
            try {
                const response = await fetch('/login/email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ email, password })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = '/';
                } else {
                    alert(data.message || 'Login gagal');
                }
            } catch (error) {
                alert('Terjadi kesalahan');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
        
        // Send OTP
        document.getElementById('sendOtpBtn')?.addEventListener('click', async function() {
            const phone = document.getElementById('loginPhoneNumber').value;
            const btn = this;
            
            if (!phone) {
                alert('Masukkan nomor telepon');
                return;
            }
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
            
            try {
                const response = await fetch('/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ phone })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('otpSection').style.display = 'block';
                    document.getElementById('verifyOtpBtn').style.display = 'block';
                    btn.style.display = 'none';
                    alert('Kode OTP: ' + data.otp);
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Gagal mengirim OTP');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> Kirim OTP';
            }
        });
        
        // Verify OTP
        document.getElementById('loginPhoneForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const phone = document.getElementById('loginPhoneNumber').value;
            const otp = document.getElementById('loginOtp').value;
            
            if (!otp) {
                alert('Masukkan kode OTP');
                return;
            }
            
            try {
                const response = await fetch('/login/phone', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ phone, otp_code: otp })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.href = '/';
                } else {
                    alert(data.message);
                }
            } catch (error) {
                alert('Verifikasi gagal');
            }
        });
    </script>
</body>
</html>