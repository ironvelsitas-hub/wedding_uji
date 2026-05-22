@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-envelope-open-text me-2"></i> Detail Pesan & Live Chat
    </h1>
    <div>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
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
        <div class="card shadow mb-4">
            <div class="card-header bg-gold text-white">
                <h5 class="mb-0">
                    <i class="fas fa-comments me-2"></i> 
                    Live Chat dengan {{ $inquiry->name }}
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="chat-container" style="height: 500px; display: flex; flex-direction: column;">
                    <div class="chat-messages p-3" style="flex: 1; overflow-y: auto; background: #f8f9fa;" id="chatMessagesContainer">
                        <div id="chatMessagesList">
                            <div class="text-center text-muted py-5" id="chatLoading">
                                <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
                                <p>Memuat percakapan...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="chat-input p-3 border-top" style="background: white;">
                        <div class="mb-2">
                            <label class="form-label fw-bold small">Template Balasan Cepat:</label>
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
                        <div class="input-group">
                            <textarea class="form-control" id="adminChatMessage" rows="3" placeholder="Tulis pesan balasan..." style="resize: none;"></textarea>
                            <button class="btn btn-gold" onclick="sendAdminMessage()">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                        <div class="mt-2 text-end">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i> Tekan Ctrl+Enter untuk mengirim pesan
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i> Informasi Pengirim</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="120"><strong>Nama:</strong></td>
                        <td>{{ $inquiry->name }} @if(!$inquiry->is_read)<span class="badge bg-danger ms-2">Baru</span>@endif</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></td>
                    </tr>
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="text-decoration-none">
                                <i class="fab fa-whatsapp text-success me-1"></i> {{ $inquiry->phone }}
                            </a>
                         </td>
                    </tr>
                    @if($inquiry->wedding_date)
                    <tr><td><strong>Tanggal Nikah:</strong></td><td>{{ \Carbon\Carbon::parse($inquiry->wedding_date)->format('d F Y') }}</td></tr>
                    @endif
                    <tr><td><strong>Waktu Kirim:</strong></td><td>{{ $inquiry->created_at->format('d/m/Y H:i:s') }}</td></tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>@if($inquiry->is_read)<span class="badge bg-success"><i class="fas fa-check-circle"></i> Sudah Dibaca</span>
                            @else<span class="badge bg-danger"><i class="fas fa-clock"></i> Belum Dibaca</span>@endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card shadow mb-4">
            <div class="card-header {{ $inquiry->package ? 'bg-gold' : 'bg-secondary' }} text-white">
                <h5 class="mb-0"><i class="fas fa-gift me-2"></i> Detail Paket yang Dipilih</h5>
            </div>
            <div class="card-body">
                @if($inquiry->package)
                    @php
                        $packagePrice = null;
                        $packageFeatures = [];
                        if ($inquiry->package == 'Paket Silver') {
                            $packagePrice = 'Rp 25.000.000';
                            $packageFeatures = ['Dekorasi sederhana', 'Dokumentasi foto', 'Undangan 100 pcs', 'Wedding organizer'];
                        } elseif ($inquiry->package == 'Paket Gold') {
                            $packagePrice = 'Rp 50.000.000';
                            $packageFeatures = ['Dekorasi premium', 'Dokumentasi foto & video', 'Makeup pengantin', 'Undangan 200 pcs', 'Wedding organizer', 'Katering untuk 100 orang'];
                        } elseif ($inquiry->package == 'Paket Platinum') {
                            $packagePrice = 'Rp 100.000.000';
                            $packageFeatures = ['Dekorasi mewah', 'Dokumentasi foto & video cinematic', 'Makeup & styling lengkap', 'Undangan 300 pcs', 'Wedding organizer premium', 'Katering untuk 200 orang', 'Live music', 'Fotobooth'];
                        }
                    @endphp
                    <div class="text-center mb-3">
                        <span class="badge bg-warning py-2 px-3 mb-2"><i class="fas fa-star me-1"></i> Paket Pilihan Klien</span>
                        <h4 class="mb-2">{{ $inquiry->package }}</h4>
                        <h5 class="text-gold mb-3">{{ $packagePrice }}</h5>
                    </div>
                    <div class="border-top pt-3">
                        <strong class="d-block mb-2"><i class="fas fa-list-check me-2 text-gold"></i> Fitur Paket:</strong>
                        <ul class="list-unstyled mb-0">
                            @foreach($packageFeatures as $feature)
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Klien belum memilih paket</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: #d4af37; }
    .bg-gold { background-color: #d4af37; }
    .btn-outline-gold { border: 1px solid #d4af37; color: #d4af37; background: transparent; }
    .btn-outline-gold:hover { background-color: #d4af37; color: white; }
    .btn-gold { background-color: #d4af37; color: white; transition: all 0.3s ease; }
    .btn-gold:hover { background-color: #c5a028; color: white; transform: translateY(-2px); }
    .chat-messages { scroll-behavior: smooth; }
    
    .message-user {
        margin-bottom: 15px;
        animation: fadeInUp 0.3s ease-out;
        display: flex;
        justify-content: flex-start;
    }
    .message-user .message-content {
        background: #e9ecef;
        padding: 10px 15px;
        border-radius: 15px 15px 15px 4px;
        max-width: 80%;
        color: #333;
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
        border-radius: 15px 15px 4px 15px;
        max-width: 80%;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
// Chat System - Admin Side
let chatIntervalAdmin = null;
let adminSessionId = '{{ $sessionId ?? "" }}';

// Template balasan cepat
function setTemplate(type) {
    const textarea = document.getElementById('adminChatMessage');
    const clientName = '{{ $inquiry->name }}';
    const packageName = '{{ $inquiry->package }}';
    
    let message = '';
    switch(type) {
        case 'konfirmasi':
            message = `Halo ${clientName}, terima kasih telah memilih Perfect Wedding. Pesanan Anda untuk paket ${packageName} telah kami konfirmasi. Tim kami akan segera menghubungi Anda. Terima kasih!`;
            break;
        case 'konsultasi':
            message = `Halo ${clientName}, terima kasih atas ketertarikan Anda pada paket ${packageName}. Kami ingin mengundang Anda untuk konsultasi gratis. Silakan konfirmasi waktu yang tersedia. Terima kasih!`;
            break;
        case 'followup':
            message = `Halo ${clientName}, kami ingin menanyakan apakah ada yang bisa kami bantu terkait paket ${packageName}? Tim kami siap membantu Anda. Terima kasih!`;
            break;
    }
    textarea.value = message;
    textarea.focus();
}

// Kirim pesan dari admin
async function sendAdminMessage() {
    const messageInput = document.getElementById('adminChatMessage');
    const message = messageInput.value.trim();
    
    if (!message) {
        alert('Silakan tulis pesan terlebih dahulu');
        return;
    }
    
    messageInput.disabled = true;
    messageInput.style.opacity = '0.6';
    
    try {
        const response = await fetch('{{ route("chat.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: message,
                visitor_name: '{{ $inquiry->name }}',
                visitor_email: '{{ $inquiry->email }}',
                visitor_phone: '{{ $inquiry->phone }}',
                inquiry_id: {{ $inquiry->id }},
                is_from_admin: true,
                session_id: adminSessionId
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            addMessageToChat(message, 'admin');
            messageInput.value = '';
            scrollToBottom();
            showNotificationAdmin('Pesan terkirim ke klien!', 'success');
        } else {
            showNotificationAdmin('Gagal mengirim pesan', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotificationAdmin('Gagal mengirim pesan. Silakan coba lagi.', 'error');
    } finally {
        messageInput.disabled = false;
        messageInput.style.opacity = '1';
        messageInput.focus();
    }
}

// Tambah pesan ke chat display
function addMessageToChat(message, sender) {
    const chatContainer = document.getElementById('chatMessagesList');
    const loadingDiv = document.getElementById('chatLoading');
    
    if (loadingDiv) loadingDiv.style.display = 'none';
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-${sender}`;
    const senderName = sender === 'admin' ? 'Admin Perfect Wedding' : '{{ $inquiry->name }} (Klien)';
    const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    
    messageDiv.innerHTML = `
        <div class="message-content">
            <small class="opacity-75">
                <i class="fas ${sender === 'admin' ? 'fa-user-shield' : 'fa-user'} me-1"></i> 
                ${escapeHtml(senderName)} - ${time}
            </small>
            <p class="mb-0 mt-1">${escapeHtml(message)}</p>
        </div>
    `;
    chatContainer.appendChild(messageDiv);
    scrollToBottom();
}

// Load riwayat chat
async function loadChatHistoryAdmin() {
    try {
        const response = await fetch('{{ route("chat.history") }}');
        const data = await response.json();
        
        const chatContainer = document.getElementById('chatMessagesList');
        const loadingDiv = document.getElementById('chatLoading');
        
        if (loadingDiv) loadingDiv.style.display = 'none';
        chatContainer.innerHTML = '';
        
        if (data.chats && data.chats.length > 0) {
            data.chats.forEach(chat => {
                const sender = chat.is_from_admin ? 'admin' : 'user';
                const senderName = sender === 'admin' ? 'Admin Perfect Wedding' : '{{ $inquiry->name }} (Klien)';
                const time = new Date(chat.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `message-${sender}`;
                messageDiv.innerHTML = `
                    <div class="message-content">
                        <small class="opacity-75">
                            <i class="fas ${sender === 'admin' ? 'fa-user-shield' : 'fa-user'} me-1"></i> 
                            ${escapeHtml(senderName)} - ${time}
                        </small>
                        <p class="mb-0 mt-1">${escapeHtml(chat.message)}</p>
                    </div>
                `;
                chatContainer.appendChild(messageDiv);
            });
            scrollToBottom();
        }
    } catch (error) {
        console.error('Error loading chat history:', error);
    }
}

// Cek pesan baru dari user
async function checkUserMessages() {
    try {
        const response = await fetch('{{ route("chat.check") }}');
        const data = await response.json();
        
        if (data.has_reply && data.replies) {
            data.replies.forEach(reply => {
                addMessageToChat(reply.message, 'user');
            });
            scrollToBottom();
            showNotificationAdmin('Pesan baru dari klien!', 'info');
        }
    } catch (error) {
        console.error('Error checking messages:', error);
    }
}

// Notifikasi
function showNotificationAdmin(message, type = 'success') {
    let container = document.getElementById('adminNotifContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'adminNotifContainer';
        container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
        document.body.appendChild(container);
    }
    
    const notif = document.createElement('div');
    const bgColor = type === 'success' ? '#28a745' : (type === 'error' ? '#dc3545' : '#17a2b8');
    notif.style.cssText = `
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
    notif.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : (type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')} me-2"></i> ${escapeHtml(message)}`;
    notif.onclick = () => notif.remove();
    container.appendChild(notif);
    setTimeout(() => notif.remove(), 4000);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function scrollToBottom() {
    const container = document.getElementById('chatMessagesContainer');
    if (container) container.scrollTop = container.scrollHeight;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    loadChatHistoryAdmin();
    if (chatIntervalAdmin) clearInterval(chatIntervalAdmin);
    chatIntervalAdmin = setInterval(checkUserMessages, 3000);
    
    const chatInput = document.getElementById('adminChatMessage');
    if (chatInput) chatInput.focus();
    
    chatInput?.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.keyCode === 13) {
            e.preventDefault();
            sendAdminMessage();
        }
    });
});

window.addEventListener('beforeunload', () => {
    if (chatIntervalAdmin) clearInterval(chatIntervalAdmin);
});
</script>
@endsection