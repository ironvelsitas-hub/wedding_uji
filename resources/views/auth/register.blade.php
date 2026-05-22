<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Perfect Wedding</title>
    
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
        .register-container {
            max-width: 500px;
            margin: 0 auto;
        }
        .register-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            background: white;
        }
        .register-header {
            background: linear-gradient(135deg, #d4af37, #c5a028);
            padding: 30px;
            text-align: center;
        }
        .register-header i {
            font-size: 60px;
            color: white;
            margin-bottom: 15px;
        }
        .register-header h3 {
            color: white;
            margin-bottom: 5px;
        }
        .register-body {
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
        .password-strength {
            height: 4px;
            margin-top: 8px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <div class="register-card">
                <div class="register-header">
                    <i class="fas fa-user-plus"></i>
                    <h3>Daftar Akun Baru</h3>
                    <p class="mb-0 text-white-50">Bergabung bersama Perfect Wedding</p>
                </div>
                <div class="register-body">
                    <form id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="regName" required>
                            <div class="invalid-feedback" id="regNameError"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="regEmail" required>
                            <div class="invalid-feedback" id="regEmailError"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="regPhone" placeholder="08123456789" required>
                            <div class="invalid-feedback" id="regPhoneError"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="regPassword" required>
                            <div class="password-strength" id="passwordStrength"></div>
                            <div class="invalid-feedback" id="regPasswordError"></div>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="regPasswordConfirm" required>
                            <div class="invalid-feedback" id="regPasswordConfirmError"></div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="regTerms">
                            <label class="form-check-label">
                                Saya menyetujui <a href="#" class="text-gold">Syarat & Ketentuan</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="fas fa-user-plus me-2"></i> Daftar
                        </button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Sudah punya akun? 
                            <a href="{{ route('login') }}" class="text-gold fw-bold">Login Sekarang</a>
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
        // Password strength indicator
        const passwordInput = document.getElementById('regPassword');
        const strengthBar = document.getElementById('passwordStrength');
        
        passwordInput?.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            const width = (strength / 5) * 100;
            strengthBar.style.width = width + '%';
            
            if (strength <= 2) {
                strengthBar.style.backgroundColor = '#dc3545';
            } else if (strength <= 4) {
                strengthBar.style.backgroundColor = '#ffc107';
            } else {
                strengthBar.style.backgroundColor = '#28a745';
            }
        });
        
        // Register form submission
        document.getElementById('registerForm')?.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const name = document.getElementById('regName').value;
            const email = document.getElementById('regEmail').value;
            const phone = document.getElementById('regPhone').value;
            const password = document.getElementById('regPassword').value;
            const passwordConfirm = document.getElementById('regPasswordConfirm').value;
            const terms = document.getElementById('regTerms').checked;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Reset errors
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            
            // Validate
            if (!name || !email || !phone || !password || !passwordConfirm) {
                alert('Semua field harus diisi!');
                return;
            }
            
            if (password !== passwordConfirm) {
                document.getElementById('regPasswordConfirm').classList.add('is-invalid');
                document.getElementById('regPasswordConfirmError').textContent = 'Password tidak cocok';
                return;
            }
            
            if (password.length < 6) {
                document.getElementById('regPassword').classList.add('is-invalid');
                document.getElementById('regPasswordError').textContent = 'Password minimal 6 karakter';
                return;
            }
            
            if (!terms) {
                alert('Anda harus menyetujui Syarat & Ketentuan');
                return;
            }
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            
            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        phone: phone,
                        password: password,
                        password_confirmation: passwordConfirm
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Registrasi berhasil! Silakan login.');
                    window.location.href = '/login';
                } else if (data.errors) {
                    for (const [field, messages] of Object.entries(data.errors)) {
                        let input, errorDiv;
                        switch(field) {
                            case 'name':
                                input = document.getElementById('regName');
                                errorDiv = document.getElementById('regNameError');
                                break;
                            case 'email':
                                input = document.getElementById('regEmail');
                                errorDiv = document.getElementById('regEmailError');
                                break;
                            case 'phone':
                                input = document.getElementById('regPhone');
                                errorDiv = document.getElementById('regPhoneError');
                                break;
                            case 'password':
                                input = document.getElementById('regPassword');
                                errorDiv = document.getElementById('regPasswordError');
                                break;
                            default:
                                continue;
                        }
                        if (input) input.classList.add('is-invalid');
                        if (errorDiv) errorDiv.textContent = messages[0];
                    }
                } else {
                    alert(data.message || 'Registrasi gagal');
                }
            } catch (error) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    </script>
</body>
</html>