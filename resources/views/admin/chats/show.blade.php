@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-comments me-2"></i> Balas Chat
    </h1>
    <div>
        <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        @if($chat->status != 'closed')
        <form action="{{ route('admin.chats.close', $chat) }}" method="POST" style="display: inline-block">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-warning" onclick="return confirm('Tutup chat ini?')">
                <i class="fas fa-times-circle"></i> Tutup Chat
            </button>
        </form>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-7">
        <!-- Riwayat Percakapan -->
        <div class="card shadow">
            <div class="card-header bg-gold text-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i> Riwayat Percakapan
                </h5>
            </div>
            <div class="card-body" style="height: 500px; overflow-y: auto;" id="chat-messages-container">
                <div id="chat-messages-list">
                    <div class="text-center text-muted py-5" id="chat-loading">
                        <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
                        <p>Memuat percakapan...</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Form Balas Pesan -->
        @if($chat->status != 'closed')
        <div class="card shadow mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-reply-all me-2"></i> Balas Pesan
                </h5>
            </div>
            <div class="card-body">
                <form id="reply-form" action="{{ route('admin.chats.reply', $chat) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="admin_reply" class="form-label">Balasan</label>
                        <textarea class="form-control" id="admin_reply" name="admin_reply" rows="4" required placeholder="Tulis balasan Anda..."></textarea>
                    </div>
                    
                    <!-- Template Balasan Cepat -->
                    <div class="mb-3">
                        <label class="form-label">Template Balasan Cepat:</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-gold btn-sm w-100" onclick="setTemplate('konfirmasi')">
                                    <i class="fas fa-check-circle me-1"></i> Konfirmasi
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-gold btn-sm w-100" onclick="setTemplate('konsultasi')">
                                    <i class="fas fa-calendar-alt me-1"></i> Konsultasi
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-gold btn-sm w-100" onclick="setTemplate('followup')">
                                    <i class="fas fa-phone me-1"></i> Follow Up
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-gold w-100" id="send-reply-btn">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Balasan
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="card shadow mt-4">
            <div class="card-body text-center py-4">
                <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                <h6 class="text-muted">Chat ini sudah ditutup</h6>
                <p class="small text-muted">Tidak dapat mengirim balasan untuk chat yang sudah ditutup.</p>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-5">
        <!-- Informasi Pengunjung -->
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i> Informasi Pengunjung
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="100"><strong>Nama:</strong></td>
                        <td>{{ $chat->visitor_name ?? '-' }} @if($chat->status == 'pending')<span class="badge bg-danger ms-2">Belum Dibalas</span>@elseif($chat->status == 'replied')<span class="badge bg-success ms-2">Sudah Dibalas</span>@endif</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $chat->visitor_email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $chat->visitor_phone ?? '-' }}</td>
                    </tr>
                    @if($chat->wedding_date)
                    <tr>
                        <td><strong>Tanggal Nikah:</strong></td>
                        <td>{{ \Carbon\Carbon::parse($chat->wedding_date)->format('d F Y') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Waktu Mulai:</strong></td>
                        <td>{{ $chat->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($chat->status == 'pending')
                                <span class="badge bg-warning">Menunggu Balasan</span>
                            @elseif($chat->status == 'replied')
                                <span class="badge bg-success">Sudah Dibalas</span>
                            @else
                                <span class="badge bg-secondary">Ditutup</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <!-- Informasi Paket (jika ada) -->
        @if(isset($chat->inquiry) && $chat->inquiry && $chat->inquiry->package)
        <div class="card shadow">
            <div class="card-header bg-gold text-white">
                <h5 class="mb-0">
                    <i class="fas fa-gift me-2"></i> Paket yang Diminati
                </h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <span class="badge bg-warning py-2 px-3 mb-2">
                        <i class="fas fa-star me-1"></i> {{ $chat->inquiry->package }}
                    </span>
                    <p class="mt-2 mb-0 text-muted small">
                        Klien tertarik dengan paket ini
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .text-gold { color: #d4af37; }
    .bg-gold { background-color: #d4af37; }
    .btn-gold { background-color: #d4af37; color: white; }
    .btn-gold:hover { background-color: #c5a028; color: white; }
    .btn-outline-gold { border: 1px solid #d4af37; color: #d4af37; background: transparent; }
    .btn-outline-gold:hover { background-color: #d4af37; color: white; }
    
    .message-user {
        margin-bottom: 15px;
        animation: fadeInUp 0.3s ease-out;
        display: flex;
        justify-content: flex-start;
    }
    .message-user .message-content {
        background: #e9ecef;
        color: #333;
        padding: 10px 15px;
        border-radius: 18px 18px 18px 4px;
        max-width: 80%;
    }
    
    .message-admin {
        margin-bottom: 15px;
        animation: fadeInUp 0.3s ease-out;
        display: flex;
        justify-content: flex-end;
    }
    .message-admin .message-content {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 18px 18px 4px 18px;
        max-width: 80%;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
// Auto refresh chat messages
let chatInterval = null;
let lastMessageId = 0;

// Set template balasan cepat
function setTemplate(type) {
    const textarea = document.getElementById('admin_reply');
    if (!textarea) return;
    
    let message = '';
    const visitorName = '{{ $chat->visitor_name ?? 'Klien' }}';
    const packageName = '{{ $chat->inquiry->package ?? '' }}';
    
    switch(type) {
        case 'konfirmasi':
            message = `Halo ${visitorName}, terima kasih telah menghubungi Perfect Wedding.\n\n`;
            message += `Kami dengan senang hati mengkonfirmasi bahwa pesanan Anda untuk paket ${packageName} telah kami terima.\n\n`;
            message += `Tim kami akan segera menghubungi Anda untuk informasi lebih lanjut.\n\n`;
            message += `Terima kasih atas kepercayaan Anda.\n\nSalam hangat,\nTim Perfect Wedding`;
            break;
        case 'konsultasi':
            message = `Halo ${visitorName}, terima kasih atas ketertarikan Anda pada layanan kami.\n\n`;
            message += `Kami mengundang Anda untuk konsultasi gratis guna membahas lebih detail tentang paket ${packageName}.\n\n`;
            message += `Silakan konfirmasi waktu yang tersedia untuk konsultasi.\n\n`;
            message += `Salam,\nTim Perfect Wedding`;
            break;
        case 'followup':
            message = `Halo ${visitorName}, kami ingin menanyakan apakah ada yang bisa kami bantu terkait paket ${packageName}?\n\n`;
            message += `Tim kami siap membantu mewujudkan pernikahan impian Anda.\n\n`;
            message += `Terima kasih.\n\nSalam,\nTim Perfect Wedding`;
            break;
        default:
            return;
    }
    
    textarea.value = message;
    textarea.focus();
}

// Kirim balasan via AJAX (tanpa reload)
async function sendReplyViaAjax() {
    const replyText = document.getElementById('admin_reply').value.trim();
    if (!replyText) {
        alert('Silakan tulis balasan terlebih dahulu');
        return;
    }
    
    const submitBtn = document.getElementById('send-reply-btn');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
    
    try {
        const response = await fetch('{{ route("admin.chats.reply", $chat) }}', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ admin_reply: replyText })
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Tambahkan pesan ke chat display
            addMessageToChat(replyText, 'admin');
            document.getElementById('admin_reply').value = '';
            scrollToBottom();
            showToast('Balasan berhasil dikirim!', 'success');
        } else {
            showToast('Gagal mengirim balasan', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('Terjadi kesalahan', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
}

// Tambah pesan ke tampilan chat
function addMessageToChat(message, sender) {
    const chatContainer = document.getElementById('chat-messages-list');
    const loadingDiv = document.getElementById('chat-loading');
    
    if (loadingDiv) loadingDiv.style.display = 'none';
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-${sender}`;
    const senderName = sender === 'admin' ? 'Admin Perfect Wedding' : '{{ $chat->visitor_name ?? "Klien" }}';
    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    messageDiv.innerHTML = `
        <div class="message-content">
            <small class="opacity-75">
                <i class="fas ${sender === 'admin' ? 'fa-user-shield' : 'fa-user'} me-1"></i> 
                ${senderName} - ${time}
            </small>
            <p class="mb-0 mt-1">${escapeHtml(message)}</p>
        </div>
    `;
    chatContainer.appendChild(messageDiv);
    scrollToBottom();
}

// Load semua pesan chat
async function loadChatMessages() {
    try {
        const response = await fetch('{{ route("chat.history") }}');
        const data = await response.json();
        
        const chatContainer = document.getElementById('chat-messages-list');
        const loadingDiv = document.getElementById('chat-loading');
        
        if (loadingDiv) loadingDiv.style.display = 'none';
        
        if (data.chats && data.chats.length > 0) {
            chatContainer.innerHTML = '';
            data.chats.forEach(chat => {
                const sender = chat.is_from_admin ? 'admin' : 'user';
                const senderName = sender === 'admin' ? 'Admin Perfect Wedding' : '{{ $chat->visitor_name ?? "Klien" }}';
                const time = new Date(chat.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message-${sender}`;
                messageDiv.innerHTML = `
                    <div class="message-content">
                        <small class="opacity-75">
                            <i class="fas ${sender === 'admin' ? 'fa-user-shield' : 'fa-user'} me-1"></i> 
                            ${senderName} - ${time}
                        </small>
                        <p class="mb-0 mt-1">${escapeHtml(chat.message)}</p>
                    </div>
                `;
                chatContainer.appendChild(messageDiv);
            });
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error loading chat messages:', error);
    }
}

// Cek pesan baru dari user
async function checkNewUserMessages() {
    try {
        const response = await fetch('{{ route("chat.check") }}');
        const data = await response.json();
        
        if (data.has_reply && data.replies) {
            data.replies.forEach(reply => {
                // Cek duplikasi
                const existingMessages = document.querySelectorAll('.message-user');
                let isDuplicate = false;
                existingMessages.forEach(msg => {
                    if (msg.innerHTML.includes(escapeHtml(reply.message))) {
                        isDuplicate = true;
                    }
                });
                
                if (!isDuplicate) {
                    addMessageToChat(reply.message, 'user');
                    showToast('Pesan baru dari klien!', 'info');
                    playNotificationSound();
                }
            });
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error checking new messages:', error);
    }
}

// Play notifikasi suara
function playNotificationSound() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = 800;
        gainNode.gain.value = 0.2;
        
        oscillator.start();
        setTimeout(() => oscillator.stop(), 300);
        setTimeout(() => audioContext.close(), 500);
    } catch(e) {
        console.log('Sound not supported');
    }
}

// Tampilkan toast notifikasi
function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#28a745' : (type === 'error' ? '#dc3545' : '#17a2b8');
    toast.style.cssText = `
        background: ${bgColor};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease-out;
        cursor: pointer;
        min-width: 250px;
    `;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')} me-2"></i>
        ${message}
    `;
    toast.onclick = () => toast.remove();
    
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// Scroll ke bawah
function scrollToBottom() {
    const container = document.getElementById('chat-messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Escape HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadChatMessages();
    
    // Auto refresh setiap 3 detik
    if (chatInterval) clearInterval(chatInterval);
    chatInterval = setInterval(checkNewUserMessages, 3000);
    
    // Submit form via AJAX
    const replyForm = document.getElementById('reply-form');
    if (replyForm) {
        replyForm.onsubmit = async function(e) {
            e.preventDefault();
            await sendReplyViaAjax();
        };
    }
});

// Cleanup
window.addEventListener('beforeunload', () => {
    if (chatInterval) clearInterval(chatInterval);
});
</script>
@endsection