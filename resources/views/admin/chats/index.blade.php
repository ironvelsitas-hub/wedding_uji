@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-comments me-2"></i> Management Live Chat
    </h1>
    <div>
        <span class="badge bg-warning me-2">
            <i class="fas fa-clock"></i> Pending: {{ $pendingChats->count() }}
        </span>
        <span class="badge bg-success">
            <i class="fas fa-check-circle"></i> Total Chat: {{ $allChats->total() }}
        </span>
    </div>
</div>

<!-- Pending Chats Section -->
<div class="card shadow mb-4">
    <div class="card-header bg-warning text-white">
        <h5 class="mb-0">
            <i class="fas fa-bell me-2"></i> Pesan Belum Dibalas
        </h5>
    </div>
    <div class="card-body">
        @forelse($pendingChats as $chat)
        <div class="chat-preview mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 45px; height: 45px;">
                            <i class="fas fa-user text-white fa-lg"></i>
                        </div>
                        <div>
                            <strong class="fs-5">{{ $chat->visitor_name ?? 'Pengunjung' }}</strong>
                            <small class="text-muted ms-2">
                                <i class="fas fa-clock"></i> {{ $chat->created_at->diffForHumans() }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-envelope me-1"></i> {{ $chat->visitor_email ?? 'Email tidak tersedia' }}
                            </small>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">
                            <strong>Pesan Terakhir:</strong><br>
                            "{{ Str::limit($chat->message, 150) }}"
                        </p>
                    </div>
                    @if($chat->visitor_phone)
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-phone me-1"></i> {{ $chat->visitor_phone }}
                    </small>
                    @endif
                </div>
                <div class="ms-3">
                    <a href="{{ route('admin.chats.show', $chat) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-reply"></i> Balas Sekarang
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
            <h5 class="text-muted">Tidak ada pesan yang perlu dibalas</h5>
            <p class="text-muted">Semua pesan sudah dibalas oleh admin</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Riwayat Semua Chat - Group by User -->
<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i> Riwayat Chat per Pengunjung
        </h5>
    </div>
    <div class="card-body">
        <!-- Group chats by visitor -->
        @php
            $groupedChats = [];
            foreach($allChats as $chat) {
                $key = $chat->visitor_email ?? $chat->visitor_name ?? 'Anonymous';
                if (!isset($groupedChats[$key])) {
                    $groupedChats[$key] = [
                        'name' => $chat->visitor_name ?? 'Pengunjung',
                        'email' => $chat->visitor_email ?? '-',
                        'phone' => $chat->visitor_phone ?? '-',
                        'first_message' => $chat->created_at,
                        'last_message' => $chat->created_at,
                        'total_messages' => 0,
                        'status' => $chat->status,
                        'session_id' => $chat->session_id,
                        'chats' => []
                    ];
                }
                
                $groupedChats[$key]['total_messages']++;
                $groupedChats[$key]['chats'][] = $chat;
                
                if ($chat->created_at > $groupedChats[$key]['last_message']) {
                    $groupedChats[$key]['last_message'] = $chat->created_at;
                }
                if ($chat->created_at < $groupedChats[$key]['first_message']) {
                    $groupedChats[$key]['first_message'] = $chat->created_at;
                }
                // Update status berdasarkan chat terakhir
                if ($chat->status == 'pending') {
                    $groupedChats[$key]['status'] = 'pending';
                } elseif ($chat->status == 'replied' && $groupedChats[$key]['status'] != 'pending') {
                    $groupedChats[$key]['status'] = 'replied';
                }
            }
        @endphp
        
        <div class="accordion" id="chatAccordion">
            @foreach($groupedChats as $index => $visitor)
            <div class="accordion-item mb-3 border rounded">
                <div class="accordion-header" id="heading{{ $index }}">
                    <div class="d-flex justify-content-between align-items-center p-3 bg-light" 
                         style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div class="bg-{{ $visitor['status'] == 'pending' ? 'warning' : ($visitor['status'] == 'replied' ? 'success' : 'secondary') }} rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-white fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $visitor['name'] }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i> {{ $visitor['email'] }}
                                    @if($visitor['phone'] != '-')
                                    <i class="fas fa-phone ms-2 me-1"></i> {{ $visitor['phone'] }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="mb-1">
                                @if($visitor['status'] == 'pending')
                                    <span class="badge bg-warning">Menunggu Balasan</span>
                                @elseif($visitor['status'] == 'replied')
                                    <span class="badge bg-success">Sudah Dibalas</span>
                                @else
                                    <span class="badge bg-secondary">Ditutup</span>
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-comment me-1"></i> {{ $visitor['total_messages'] }} pesan |
                                <i class="fas fa-clock ms-2 me-1"></i> {{ \Carbon\Carbon::parse($visitor['last_message'])->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
                
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#chatAccordion">
                    <div class="accordion-body p-0">
                        <!-- Chat Messages -->
                        <div class="chat-messages p-3" style="max-height: 400px; overflow-y: auto; background: #f8f9fa;">
                            @foreach($visitor['chats'] as $chatMsg)
                            <div class="message-{{ $chatMsg->is_from_admin ? 'admin' : 'user' }} mb-3">
                                <div class="d-flex {{ $chatMsg->is_from_admin ? 'justify-content-end' : 'justify-content-start' }}">
                                    <div class="message-content {{ $chatMsg->is_from_admin ? 'message-admin-bubble' : 'message-user-bubble' }}">
                                        <small class="opacity-75 d-block mb-1">
                                            <i class="fas {{ $chatMsg->is_from_admin ? 'fa-user-shield' : 'fa-user' }} me-1"></i>
                                            {{ $chatMsg->is_from_admin ? 'Admin Perfect Wedding' : $visitor['name'] }}
                                            <span class="ms-2">•</span>
                                            <span class="ms-2">{{ $chatMsg->created_at->format('H:i, d/m/Y') }}</span>
                                        </small>
                                        <p class="mb-0">{{ $chatMsg->message }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="p-3 border-top bg-white">
                            <a href="{{ route('admin.chats.show', $visitor['session_id']) }}" class="btn btn-gold w-100">
                                <i class="fas fa-reply-all me-2"></i> Balas Percakapan Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($allChats instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $allChats->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .text-gold { color: #d4af37; }
    .bg-gold { background-color: #d4af37; }
    .btn-gold { background-color: #d4af37; color: white; }
    .btn-gold:hover { background-color: #c5a028; color: white; }
    
    .chat-preview:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding-left: 10px;
        transition: all 0.3s ease;
    }
    
    .message-user-bubble {
        background: #e9ecef;
        color: #333;
        padding: 10px 15px;
        border-radius: 18px 18px 18px 4px;
        max-width: 80%;
    }
    
    .message-admin-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 18px 18px 4px 18px;
        max-width: 80%;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: transparent;
        box-shadow: none;
    }
    
    .accordion-item {
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #dee2e6;
    }
    
    .bg-warning {
        background-color: #d4af37 !important;
    }
    
    .accordion-header .d-flex:hover {
        background-color: #e9ecef !important;
    }
    
    /* Perbaikan tampilan chat bubble */
    .message-user .message-user-bubble,
    .message-admin .message-admin-bubble {
        word-wrap: break-word;
        white-space: normal;
    }
    
    /* Scrollbar styling */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }
    
    .chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .chat-messages::-webkit-scrollbar-thumb {
        background: #d4af37;
        border-radius: 10px;
    }
    
    /* Badge styling */
    .badge.bg-warning {
        background-color: #d4af37 !important;
        color: #000;
    }
    
    .badge.bg-success {
        background-color: #28a745 !important;
    }
    
    /* Card header styling */
    .card-header.bg-warning {
        background-color: #d4af37 !important;
    }
    
    /* Accordion styling */
    .accordion-item:first-of-type {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .accordion-item:last-of-type {
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
    }
</style>

@push('scripts')
<script>
// Auto refresh untuk pending chats (opsional)
let refreshInterval = setInterval(function() {
    // Hanya refresh jika halaman tidak sedang di-scroll
    if (!scrolling) {
        location.reload();
    }
}, 30000); // Refresh setiap 30 detik

let scrolling = false;
window.addEventListener('scroll', function() {
    scrolling = true;
    setTimeout(function() {
        scrolling = false;
    }, 1000);
});

// Cleanup interval saat page unload
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>
@endpush
@endsection