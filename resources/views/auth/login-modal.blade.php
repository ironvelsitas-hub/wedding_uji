<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gold text-white">
                <h5 class="modal-title">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email-login" type="button" role="tab">
                            <i class="fas fa-envelope me-1"></i> Email
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone-login" type="button" role="tab">
                            <i class="fas fa-phone me-1"></i> Telepon
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="facebook-tab" data-bs-toggle="tab" data-bs-target="#facebook-login" type="button" role="tab">
                            <i class="fab fa-facebook me-1"></i> Facebook
                        </button>
                    </li>
                </ul>
                
                <!-- Tab Content -->
                <div class="tab-content" id="loginTabContent">
                    <!-- Login with Email -->
                    <div class="tab-pane fade show active" id="email-login" role="tabpanel">
                        <form id="login-email-form">
                            @csrf
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="login-email" name="email" required>
                                <div class="invalid-feedback" id="login-email-error"></div>
                            </div>
                            <div class="mb-3">
                                <label for="login-password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="login-password" name="password" required>
                                <div class="invalid-feedback" id="login-password-error"></div>
                            </div>
                            <button type="submit" class="btn btn-gold w-100" id="email-login-btn">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <small>Belum punya akun? 
                                <button type="button" class="btn btn-link text-gold p-0" onclick="showRegisterModal()" style="text-decoration: none;">
                                    Daftar Sekarang
                                </button>
                            </small>
                        </div>
                    </div>
                    
                    <!-- Login with Phone -->
                    <div class="tab-pane fade" id="phone-login" role="tabpanel">
                        <form id="login-phone-form">
                            @csrf
                            <div class="mb-3">
                                <label for="login-phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="login-phone" name="phone" placeholder="08123456789" required>
                                <div class="invalid-feedback" id="login-phone-error"></div>
                            </div>
                            <div class="mb-3" id="otp-section" style="display: none;">
                                <label for="login-otp" class="form-label">Kode OTP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="login-otp" name="otp_code" maxlength="6" placeholder="6 digit">
                                    <button class="btn btn-outline-gold" type="button" id="verify-otp-btn">
                                        <i class="fas fa-check"></i> Verifikasi
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="login-otp-error"></div>
                            </div>
                            <button type="button" class="btn btn-gold w-100" id="send-otp-btn">
                                <i class="fas fa-paper-plane me-2"></i> Kirim OTP
                            </button>
                        </form>
                        <div class="text-center mt-3">
                            <small>Belum punya akun? 
                                <button type="button" class="btn btn-link text-gold p-0" onclick="showRegisterModal()" style="text-decoration: none;">
                                    Daftar Sekarang
                                </button>
                            </small>
                        </div>
                    </div>
                    
                    <!-- Login with Facebook -->
                    <div class="tab-pane fade" id="facebook-login" role="tabpanel">
                        <div class="text-center py-4">
                            <i class="fab fa-facebook fa-4x text-primary mb-3"></i>
                            <p>Login dengan akun Facebook Anda</p>
                            <a href="{{ route('login.facebook') }}" class="btn btn-primary">
                                <i class="fab fa-facebook me-2"></i> Login dengan Facebook
                            </a>
                        </div>
                        <div class="text-center mt-3">
                            <small>Belum punya akun? 
                                <button type="button" class="btn btn-link text-gold p-0" onclick="showRegisterModal()" style="text-decoration: none;">
                                    Daftar Sekarang
                                </button>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gold text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i> Daftar Akun Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Silakan isi form di bawah untuk mendaftar akun baru.</p>
                
                <form id="register-form">
                    @csrf
                    <div class="mb-3">
                        <label for="reg-name" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="reg-name" name="name" required>
                        <div class="invalid-feedback" id="reg-name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reg-email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="reg-email" name="email" required>
                        <div class="invalid-feedback" id="reg-email-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reg-phone" class="form-label">Nomor Telepon *</label>
                        <input type="tel" class="form-control" id="reg-phone" name="phone" placeholder="08123456789" required>
                        <div class="invalid-feedback" id="reg-phone-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reg-password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="reg-password" name="password" required>
                        <div class="invalid-feedback" id="reg-password-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reg-password-confirm" class="form-label">Konfirmasi Password *</label>
                        <input type="password" class="form-control" id="reg-password-confirm" name="password_confirmation" required>
                        <div class="invalid-feedback" id="reg-password-confirm-error"></div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya menyetujui <a href="#">Syarat & Ketentuan</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-gold w-100" id="register-btn">
                        <i class="fas fa-user-plus me-2"></i> Daftar
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <small>Sudah punya akun? 
                        <button type="button" class="btn btn-link text-gold p-0" onclick="showLoginModalFromRegister()" style="text-decoration: none;">
                            Login Sekarang
                        </button>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: #d4af37 !important; }
    .bg-gold { background-color: #d4af37; }
    .btn-gold { background-color: #d4af37; color: white; border: none; }
    .btn-gold:hover { background-color: #c5a028; color: white; }
    .btn-outline-gold { border: 1px solid #d4af37; color: #d4af37; background: transparent; }
    .btn-outline-gold:hover { background-color: #d4af37; color: white; }
    .btn-link.text-gold { color: #d4af37 !important; text-decoration: none; }
    .btn-link.text-gold:hover { text-decoration: underline !important; }
    .nav-tabs .nav-link { color: #333; border: none; padding: 10px 20px; transition: all 0.3s ease; }
    .nav-tabs .nav-link.active { color: #d4af37; border-bottom: 2px solid #d4af37; background: transparent; }
    .nav-tabs .nav-link:hover { color: #d4af37; }
    .modal-header { border-bottom: none; }
    .modal-footer { border-top: none; }
    .modal-content { border-radius: 15px; overflow: hidden; }
    
    /* Loading animation */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .fa-spin { animation: spin 1s linear infinite; }
</style>

<script>
// Fungsi untuk menampilkan modal register
window.showRegisterModal = function() {
    console.log('Opening register modal');
    const loginModalEl = document.getElementById('loginModal');
    const registerModalEl = document.getElementById('registerModal');
    
    if (loginModalEl) {
        const loginModal = bootstrap.Modal.getInstance(loginModalEl);
        if (loginModal) loginModal.hide();
    }
    
    if (registerModalEl) {
        const registerModal = new bootstrap.Modal(registerModalEl);
        registerModal.show();
    } else {
        console.error('Register modal not found');
    }
};

// Fungsi untuk menampilkan modal login dari register
window.showLoginModalFromRegister = function() {
    console.log('Opening login modal from register');
    const registerModalEl = document.getElementById('registerModal');
    const loginModalEl = document.getElementById('loginModal');
    
    if (registerModalEl) {
        const registerModal = bootstrap.Modal.getInstance(registerModalEl);
        if (registerModal) registerModal.hide();
    }
    
    if (loginModalEl) {
        const loginModal = new bootstrap.Modal(loginModalEl);
        loginModal.show();
    }
};

// Fungsi global untuk menampilkan modal login
window.showLoginModal = function() {
    console.log('Opening login modal');
    const loginModalEl = document.getElementById('loginModal');
    if (loginModalEl) {
        const loginModal = new bootstrap.Modal(loginModalEl);
        loginModal.show();
    }
};

// Register Form Submission
document.getElementById('register-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    console.log('Register form submitted');
    
    // Reset error styles
    document.querySelectorAll('#register-form .is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.querySelectorAll('#register-form .invalid-feedback').forEach(el => {
        el.classList.remove('show');
    });
    
    // Disable submit button
    const submitBtn = document.getElementById('register-btn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
    
    // Get form values
    const name = document.getElementById('reg-name').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const phone = document.getElementById('reg-phone').value.trim();
    const password = document.getElementById('reg-password').value;
    const passwordConfirm = document.getElementById('reg-password-confirm').value;
    const terms = document.getElementById('terms').checked;
    
    // Validate required fields
    if (!name || !email || !phone || !password || !passwordConfirm) {
        alert('Semua field wajib diisi!');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById('reg-email').classList.add('is-invalid');
        document.getElementById('reg-email-error').textContent = 'Format email tidak valid';
        document.getElementById('reg-email-error').classList.add('show');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    // Validate phone format (min 10 digits)
    const phoneRegex = /^[0-9]{10,15}$/;
    if (!phoneRegex.test(phone.replace(/\D/g, ''))) {
        document.getElementById('reg-phone').classList.add('is-invalid');
        document.getElementById('reg-phone-error').textContent = 'Nomor telepon harus 10-15 digit';
        document.getElementById('reg-phone-error').classList.add('show');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    // Validate password length
    if (password.length < 6) {
        document.getElementById('reg-password').classList.add('is-invalid');
        document.getElementById('reg-password-error').textContent = 'Password minimal 6 karakter';
        document.getElementById('reg-password-error').classList.add('show');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    // Validate password match
    if (password !== passwordConfirm) {
        document.getElementById('reg-password-confirm').classList.add('is-invalid');
        document.getElementById('reg-password-confirm-error').textContent = 'Password tidak cocok';
        document.getElementById('reg-password-confirm-error').classList.add('show');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    // Validate terms
    if (!terms) {
        alert('Anda harus menyetujui Syarat & Ketentuan');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        return;
    }
    
    try {
        const response = await fetch('{{ route("register") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
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
        
        if (response.ok && data.success) {
            alert('Registrasi berhasil! Selamat datang ' + name);
            
            // Reset form
            document.getElementById('register-form').reset();
            
            // Tutup modal register
            const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
            if (registerModal) registerModal.hide();
            
            // Reload halaman untuk update status login
            window.location.reload();
        } else if (response.status === 422 && data.errors) {
            for (const [field, messages] of Object.entries(data.errors)) {
                const errorDiv = document.getElementById(`reg-${field}-error`);
                const input = document.getElementById(`reg-${field}`);
                if (errorDiv) {
                    errorDiv.textContent = messages[0];
                    errorDiv.classList.add('show');
                }
                if (input) {
                    input.classList.add('is-invalid');
                }
            }
            alert('Mohon periksa kembali data Anda');
        } else {
            alert(data.message || 'Registrasi gagal. Silakan coba lagi.');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

// Login with Email Form Submission (untuk tab Email)
document.getElementById('login-email-form')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    const submitBtn = document.getElementById('email-login-btn');
    const originalText = submitBtn.innerHTML;
    
    document.getElementById('login-email').classList.remove('is-invalid');
    document.getElementById('login-password').classList.remove('is-invalid');
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
    
    try {
        const response = await fetch('{{ route("login.email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (loginModal) loginModal.hide();
            
            const selectedPackage = localStorage.getItem('selected_package');
            if (selectedPackage) {
                localStorage.removeItem('selected_package');
                window.location.href = `/contact?package=${encodeURIComponent(selectedPackage)}`;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Login gagal');
            if (data.errors) {
                if (data.errors.email) {
                    document.getElementById('login-email').classList.add('is-invalid');
                    document.getElementById('login-email-error').textContent = data.errors.email[0];
                    document.getElementById('login-email-error').classList.add('show');
                }
                if (data.errors.password) {
                    document.getElementById('login-password').classList.add('is-invalid');
                    document.getElementById('login-password-error').textContent = data.errors.password[0];
                    document.getElementById('login-password-error').classList.add('show');
                }
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});

// Send OTP Button
document.getElementById('send-otp-btn')?.addEventListener('click', async function() {
    const phone = document.getElementById('login-phone').value;
    
    if (!phone) {
        document.getElementById('login-phone').classList.add('is-invalid');
        document.getElementById('login-phone-error').textContent = 'Nomor telepon wajib diisi';
        document.getElementById('login-phone-error').classList.add('show');
        return;
    }
    
    const btn = this;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
    
    try {
        const response = await fetch('{{ route("send.otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ phone })
        });
        
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('otp-section').style.display = 'block';
            btn.style.display = 'none';
            alert('Kode OTP Anda: ' + data.otp);
        } else {
            alert(data.message || 'Gagal mengirim OTP');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal mengirim OTP. Silakan coba lagi.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
    }
});

// Verify OTP Button
document.getElementById('verify-otp-btn')?.addEventListener('click', async function() {
    const phone = document.getElementById('login-phone').value;
    const otp = document.getElementById('login-otp').value;
    
    if (!otp) {
        document.getElementById('login-otp').classList.add('is-invalid');
        document.getElementById('login-otp-error').textContent = 'Kode OTP wajib diisi';
        document.getElementById('login-otp-error').classList.add('show');
        return;
    }
    
    try {
        const response = await fetch('{{ route("login.phone") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ phone, otp_code: otp })
        });
        
        const data = await response.json();
        
        if (data.success) {
            const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
            if (loginModal) loginModal.hide();
            
            const selectedPackage = localStorage.getItem('selected_package');
            if (selectedPackage) {
                localStorage.removeItem('selected_package');
                window.location.href = `/contact?package=${encodeURIComponent(selectedPackage)}`;
            } else {
                window.location.reload();
            }
        } else {
            alert(data.message || 'Verifikasi OTP gagal');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Verifikasi gagal. Silakan coba lagi.');
    }
});

// Real-time validation untuk password match
document.getElementById('reg-password')?.addEventListener('input', checkPasswordMatch);
document.getElementById('reg-password-confirm')?.addEventListener('input', checkPasswordMatch);

function checkPasswordMatch() {
    const password = document.getElementById('reg-password').value;
    const confirm = document.getElementById('reg-password-confirm').value;
    const errorDiv = document.getElementById('reg-password-confirm-error');
    const input = document.getElementById('reg-password-confirm');
    
    if (confirm && password !== confirm) {
        errorDiv.textContent = 'Password tidak cocok';
        errorDiv.classList.add('show');
        input.classList.add('is-invalid');
    } else {
        errorDiv.classList.remove('show');
        input.classList.remove('is-invalid');
    }
}
</script>