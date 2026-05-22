@extends('layouts.app')

@section('title', 'Kontak & Live Chat - Perfect Wedding')

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <!-- Form Kontak -->
        <div class="col-lg-6 mb-4" data-aos="fade-right">
            <div class="contact-form-card">
                <h2 class="mb-3">Hubungi Kami</h2>
                <p class="mb-4 text-muted">Isi form di bawah ini untuk konsultasi gratis tentang pernikahan impian Anda. Tim kami akan segera menghubungi Anda.</p>
                
                <div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
                
                <form id="inquiry-form" action="{{ route('inquiry.store') }}" method="POST">
                    @csrf
                    
                    @if(isset($selectedPackage) && $selectedPackage)
                        <input type="hidden" name="package" value="{{ $selectedPackage }}">
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name ?? old('name') }}" required>
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email ?? old('email') }}" required>
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone ?? old('phone') }}" required>
                        <div class="invalid-feedback" id="phone-error"></div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pernikahan (Opsional)</label>
                        <input type="date" class="form-control" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}">
                        <div class="invalid-feedback" id="wedding_date-error"></div>
                    </div>
                    
                    @if(!isset($selectedPackage) || !$selectedPackage)
                    <div class="mb-3">
                        <label class="form-label">Pilih Paket Pernikahan <span class="text-danger">*</span></label>
                        <select class="form-control" id="package" name="package" required>
                            <option value="">-- Pilih Paket --</option>
                            <option value="Paket Silver" {{ old('package') == 'Paket Silver' ? 'selected' : '' }}>Paket Silver (Rp 25.000.000)</option>
                            <option value="Paket Gold" {{ old('package') == 'Paket Gold' ? 'selected' : '' }}>Paket Gold (Rp 50.000.000)</option>
                            <option value="Paket Platinum" {{ old('package') == 'Paket Platinum' ? 'selected' : '' }}>Paket Platinum (Rp 100.000.000)</option>
                        </select>
                        <div class="invalid-feedback" id="package-error"></div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Pesan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message') }}</textarea>
                        <div class="invalid-feedback" id="message-error"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-gold w-100" id="submit-btn">
                        <span id="btn-text"><i class="fas fa-paper-plane me-2"></i>Kirim Pesan</span>
                        <span id="btn-spinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Live Chat Box & Info Kontak -->
        <div class="col-lg-6 mb-4" data-aos="fade-left">
            
            <!-- Live Chat Card (Hanya untuk user yang sudah login) -->
            @auth
            <div class="card shadow live-chat-card mb-4">
                <div class="card-header bg-gold text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-comments me-2"></i>
                            <strong>Live Chat dengan Admin</strong>
                        </div>
                        <div class="chat-status-badge">
                            <div class="status-dot"></div>
                            <small>Online</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="chat-box-container" style="height: 400px; display: flex; flex-direction: column;">
                        <div class="chat-messages-area" id="chat-messages-area">
                            <div id="chat-welcome-screen" class="chat-welcome-screen">
                                <i class="fas fa-comment-dots fa-4x mb-3" style="color: #d4af37;"></i>
                                <h6>Halo, {{ Auth::user()->name ?? 'User' }}!</h6>
                                <p>Klik tombol di bawah untuk memulai chat dengan admin</p>
                                <button class="btn btn-gold btn-sm" onclick="startChat()">
                                    <i class="fas fa-play me-1"></i> Mulai Chat
                                </button>
                            </div>
                            <div id="chat-messages-list" class="chat-messages-list" style="display: none;"></div>
                        </div>
                        
                        <div id="chat-input-area" class="chat-input-area" style="display: none;">
                            <div class="input-group">
                                <textarea id="chat-message-input" rows="2" placeholder="Tulis pesan Anda..." class="form-control"></textarea>
                                <button class="btn btn-gold" onclick="sendUserMessage()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            <div class="text-end mt-1">
                                <small class="text-muted">Ctrl+Enter untuk kirim</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            
            <!-- Informasi untuk user yang belum login -->
            @guest
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-lock me-2"></i>
                            <strong>Live Chat</strong>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center py-5">
                    <i class="fas fa-comment-slash fa-4x text-muted mb-3"></i>
                    <h5>Login untuk Menggunakan Live Chat</h5>
                    <p class="text-muted">Silakan login terlebih dahulu untuk dapat menggunakan fitur live chat dengan admin.</p>
                    <a href="{{ route('login') }}" class="btn btn-gold">
                        <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                    </a>
                    <div class="mt-3">
                        <small class="text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-gold">Daftar di sini</a></small>
                    </div>
                </div>
            </div>
            @endguest
            
            <!-- Info Kontak -->
            <div class="contact-info-card">
                <h5 class="mb-3"><i class="fas fa-address-card me-2 text-gold"></i>Informasi Kontak</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="info-content">
                                <small class="text-muted">Telepon</small>
                                <a href="tel:+621212345678" class="info-link"><strong>(021) 1234-5678</strong></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <div class="info-icon bg-success"><i class="fab fa-whatsapp"></i></div>
                            <div class="info-content">
                                <small class="text-muted">WhatsApp</small>
                                <a href="https://wa.me/6281246135710?text=Halo%20Kak%20%F0%9F%91%8B%0A%0ATerima%20kasih%20sudah%20menghubungi%20kami.%0ABerikut%20format%20pemesanan%20Wedding%20Organizer%20agar%20kami%20bisa%20membantu%20lebih%20cepat%20%F0%9F%98%8A%0A%0A%F0%9F%93%8C%20Data%20Pemesanan%20WO%0A%0A1.%20Nama%20Lengkap%20%3A%20%0A%0A2.%20Tanggal%20Acara%20%3A%20%0A%0A3.%20Lokasi%20Acara%20%3A%20%0A%0A4.%20Konsep%20Pernikahan%20%3A%20(Indoor%2FOutdoor%2FAdat%2FModern%20dll)%0A%0A5.%20Jumlah%20Tamu%20%3A%20%0A%0A6.%20Paket%20yang%20diminati%20%3A%20%0A%0A7.%20Budget%20Pernikahan%20%3A%20%0A%0A8.%20Kebutuhan%20tambahan%20%3A%0A-%20Dekorasi%0A-%20Makeup%20%2F%20MUA%0A-%20Catering%0A-%20Dokumentasi%0A-%20Entertainment%0A-%20MC%0A-%20Dll%0A%0ASetelah%20data%20dikirim%2C%20tim%20kami%20akan%20segera%20membantu%20konsultasi%20dan%20memberikan%20penawaran%20terbaik%20%F0%9F%92%8D%E2%9C%A8%0A%0ATerima%20kasih%20%F0%9F%99%8F%F0%9F%8F%BB" target="_blank" class="info-link">
                                    <strong>0812-4613-5710</strong>
                                    <i class="fas fa-external-link-alt ms-1 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div class="info-content">
                                <small class="text-muted">Email</small>
                                <a href="mailto:info@perfectwedding.com" class="info-link"><strong>info@perfectwedding.com</strong></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-item">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-content">
                                <small class="text-muted">Alamat</small>
                                <strong>Jl. Kebahagiaan No. 123, Jakarta Selatan</strong>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-3">
                
                <div class="operational-hours">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><i class="fas fa-clock text-gold me-2"></i><span class="fw-bold">Jam Operasional</span></div>
                        <span class="badge bg-success">Buka</span>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-6"><small>Senin - Jumat</small><p class="mb-0">09:00 - 18:00</p></div>
                            <div class="col-6"><small>Sabtu</small><p class="mb-0">10:00 - 15:00</p></div>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small"><i class="fas fa-info-circle me-1"></i> Minggu & Hari Libur Nasional Tutup</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: #d4af37; }
    .bg-gold { background-color: #d4af37; }
    .btn-gold { background: #d4af37; color: white; border: none; border-radius: 50px; padding: 10px 25px; font-weight: 500; transition: all 0.3s ease; }
    .btn-gold:hover { background: #c5a028; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3); }
    
    .contact-form-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .live-chat-card { border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .contact-info-card { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    
    .chat-status-badge { display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 20px; font-size: 11px; }
    .status-dot { width: 8px; height: 8px; background: #2ecc71; border-radius: 50%; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { opacity: 0.5; transform: scale(1); } 100% { opacity: 1; transform: scale(1.2); } }
    
    .chat-box-container { height: 400px; display: flex; flex-direction: column; }
    .chat-messages-area { flex: 1; overflow-y: auto; padding: 15px; background: #f8f9fa; }
    .chat-welcome-screen { text-align: center; padding: 80px 20px; color: #666; }
    .chat-welcome-screen p { font-size: 13px; margin: 10px 0; }
    .chat-messages-list { display: flex; flex-direction: column; }
    
    .message-user { display: flex; justify-content: flex-end; margin-bottom: 12px; }
    .message-user .bubble { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 10px 14px; border-radius: 18px 18px 4px 18px; max-width: 85%; font-size: 13px; }
    .message-admin { display: flex; justify-content: flex-start; margin-bottom: 12px; }
    .message-admin .bubble { background: white; border: 1px solid #e0e0e0; padding: 10px 14px; border-radius: 18px 18px 18px 4px; max-width: 85%; font-size: 13px; color: #333; }
    .message-time { font-size: 9px; opacity: 0.6; margin-top: 5px; }
    
    .chat-input-area { padding: 12px; border-top: 1px solid #e0e0e0; background: white; }
    .chat-input-area .input-group { display: flex; gap: 8px; }
    .chat-input-area textarea { flex: 1; border-radius: 20px; border: 1px solid #ddd; padding: 8px 15px; resize: none; font-size: 13px; }
    .chat-input-area textarea:focus { outline: none; border-color: #d4af37; box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2); }
    .chat-input-area button { border-radius: 50%; width: 42px; height: 42px; padding: 0; }
    
    .info-item { display: flex; align-items: center; gap: 15px; padding: 10px 0; }
    .info-icon { width: 45px; height: 45px; background: #f8f9fa; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #d4af37; font-size: 20px; }
    .info-icon.bg-success { background: #25D366; color: white; }
    .info-content { flex: 1; }
    .info-link { text-decoration: none; color: #333; transition: color 0.3s ease; }
    .info-link:hover { color: #d4af37; }
    .operational-hours { background: #f8f9fa; padding: 15px; border-radius: 12px; }
    
    .chat-messages-area::-webkit-scrollbar { width: 5px; }
    .chat-messages-area::-webkit-scrollbar-track { background: #f1f1f1; }
    .chat-messages-area::-webkit-scrollbar-thumb { background: #d4af37; border-radius: 5px; }
    
    @media (max-width: 768px) {
        .live-chat-card { margin-top: 20px; }
        .chat-box-container { height: 350px; }
        .info-item { gap: 10px; }
        .info-icon { width: 40px; height: 40px; font-size: 16px; }
    }
    
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<script>
// ==================== CHAT SYSTEM ====================
// Hanya berjalan jika user sudah login
let chatActive = false;
let chatSessionId = null;
let chatInterval = null;
let currentUser = null;

// Data user dari Laravel Auth (hanya jika login)
@auth
currentUser = {
    name: '{{ Auth::user()->name }}',
    email: '{{ Auth::user()->email }}',
    phone: '{{ Auth::user()->phone ?? "" }}'
};
console.log('User logged in:', currentUser.name);
@endauth

// Start chat
async function startChat() {
    if (!currentUser) {
        alert('Silakan login terlebih dahulu untuk menggunakan live chat.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    // Gunakan user ID yang unik untuk session
    let uniqueId = 'user_{{ Auth::id() ?? 0 }}';
    chatSessionId = localStorage.getItem('chat_session_id');
    if (!chatSessionId) {
        chatSessionId = uniqueId + '_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('chat_session_id', chatSessionId);
    }
    
    const welcomeScreen = document.getElementById('chat-welcome-screen');
    const messagesList = document.getElementById('chat-messages-list');
    const inputArea = document.getElementById('chat-input-area');
    
    if (welcomeScreen) welcomeScreen.style.display = 'none';
    if (messagesList) messagesList.style.display = 'block';
    if (inputArea) inputArea.style.display = 'block';
    
    chatActive = true;
    
    await loadChatHistory();
    
    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(checkNewMessages, 3000);
}

// Kirim pesan user
async function sendUserMessage() {
    const input = document.getElementById('chat-message-input');
    const message = input.value.trim();
    
    if (!message) return;
    if (!currentUser) {
        alert('Silakan login terlebih dahulu untuk menggunakan live chat.');
        window.location.href = '{{ route("login") }}';
        return;
    }
    
    input.value = '';
    input.disabled = true;
    
    try {
        const response = await fetch('{{ route("chat.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: message,
                visitor_name: currentUser.name,
                visitor_email: currentUser.email,
                visitor_phone: currentUser.phone,
                session_id: chatSessionId
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            addMessage(message, 'user');
            input.disabled = false;
            input.focus();
            scrollToBottom();
        } else {
            input.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        input.disabled = false;
    }
}

// Add message
function addMessage(message, type) {
    const container = document.getElementById('chat-messages-list');
    if (!container) return;
    
    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    const senderName = type === 'user' ? (currentUser?.name || 'Anda') : 'Admin Perfect Wedding';
    
    const div = document.createElement('div');
    div.className = `message-${type}`;
    div.innerHTML = `
        <div class="bubble">
            <strong><small>${senderName}</small></strong><br>
            ${escapeHtml(message)}
            <div class="message-time">${time}</div>
        </div>
    `;
    container.appendChild(div);
    scrollToBottom();
}

// Load chat history
async function loadChatHistory() {
    try {
        const response = await fetch('{{ route("chat.history") }}');
        const data = await response.json();
        
        const container = document.getElementById('chat-messages-list');
        if (!container) return;
        
        container.innerHTML = '';
        
        if (data.chats && data.chats.length > 0) {
            data.chats.forEach(chat => {
                const type = chat.is_from_admin ? 'admin' : 'user';
                const time = new Date(chat.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                const senderName = type === 'user' ? (currentUser?.name || 'Anda') : 'Admin Perfect Wedding';
                
                const div = document.createElement('div');
                div.className = `message-${type}`;
                div.innerHTML = `
                    <div class="bubble">
                        <strong><small>${senderName}</small></strong><br>
                        ${escapeHtml(chat.message)}
                        <div class="message-time">${time}</div>
                    </div>
                `;
                container.appendChild(div);
            });
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error loading history:', error);
    }
}

// Check new messages
async function checkNewMessages() {
    if (!chatActive) return;
    
    try {
        const response = await fetch('{{ route("chat.check") }}');
        const data = await response.json();
        
        if (data.has_reply && data.replies) {
            data.replies.forEach(reply => {
                addMessage(reply.message, 'admin');
            });
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error checking messages:', error);
    }
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('chat-messages-area');
    if (container) container.scrollTop = container.scrollHeight;
}

// Submit form inquiry
document.getElementById('inquiry-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const spinner = document.getElementById('btn-spinner');
    
    btnText.classList.add('d-none');
    spinner.classList.remove('d-none');
    btn.disabled = true;
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            showSuccessNotification(data.message);
            this.reset();
        } else if (response.status === 422 && data.errors) {
            for (const [field, msgs] of Object.entries(data.errors)) {
                const errorDiv = document.getElementById(`${field}-error`);
                const input = document.getElementById(field);
                if (errorDiv) {
                    errorDiv.textContent = msgs[0];
                    errorDiv.classList.add('show');
                }
                if (input) input.classList.add('is-invalid');
            }
            showErrorNotification('Lengkapi data yang diperlukan');
        }
    } catch (error) {
        console.error('Error:', error);
        showErrorNotification('Terjadi kesalahan');
    } finally {
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
        btn.disabled = false;
    }
});

function showSuccessNotification(msg) {
    const container = document.getElementById('notification-container');
    const notif = document.createElement('div');
    notif.style.cssText = `
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        cursor: pointer;
        min-width: 280px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    `;
    notif.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${escapeHtml(msg)}`;
    notif.onclick = () => notif.remove();
    container.appendChild(notif);
    setTimeout(() => notif.remove(), 4000);
}

function showErrorNotification(msg) {
    const container = document.getElementById('notification-container');
    const notif = document.createElement('div');
    notif.style.cssText = `
        background: #dc3545;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        cursor: pointer;
        min-width: 280px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    `;
    notif.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i> ${escapeHtml(msg)}`;
    notif.onclick = () => notif.remove();
    container.appendChild(notif);
    setTimeout(() => notif.remove(), 4000);
}

// Remove error on input
['name', 'email', 'phone', 'message'].forEach(field => {
    const input = document.getElementById(field);
    if (input) {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorDiv = document.getElementById(`${field}-error`);
            if (errorDiv) errorDiv.classList.remove('show');
        });
    }
});

// Ctrl+Enter untuk kirim chat
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter' && chatActive) {
        e.preventDefault();
        const input = document.getElementById('chat-message-input');
        if (input && input.value.trim()) {
            sendUserMessage();
        }
    }
});

// Cleanup
window.addEventListener('beforeunload', function() {
    if (chatInterval) clearInterval(chatInterval);
});
</script>
@endsection