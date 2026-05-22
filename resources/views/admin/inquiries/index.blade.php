@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-envelope me-2"></i> Manajemen Pesan Masuk
    </h1>
    <div>
        <span class="badge bg-danger me-2">
            <i class="fas fa-envelope"></i> Belum Dibaca: {{ $inquiries->where('is_read', false)->count() }}
        </span>
        <span class="badge bg-success">
            <i class="fas fa-check-circle"></i> Total Pesan: {{ $inquiries->total() }}
        </span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow">
    <div class="card-header bg-white">
        <h5 class="mb-0">Daftar Pesan Masuk dari Klien</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Paket Dipilih</th>
                        <th>Tanggal Pernikahan</th>
                        <th>Status</th>
                        <th>Tanggal Kirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inquiry)
                    <tr class="{{ !$inquiry->is_read ? 'table-warning' : '' }}">
                        <td>{{ $inquiry->id }}</td>
                        <td>
                            <strong>{{ $inquiry->name }}</strong>
                            @if(!$inquiry->is_read)
                                <span class="badge bg-danger ms-2">Baru</span>
                            @endif
                        </td>
                        <td>
                            <a href="mailto:{{ $inquiry->email }}" class="text-decoration-none">
                                {{ $inquiry->email }}
                            </a>
                        </td>
                        <td>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" 
                               target="_blank" class="text-decoration-none">
                                <i class="fab fa-whatsapp text-success"></i> {{ $inquiry->phone }}
                            </a>
                        </td>
                        <td>
                            @if($inquiry->package)
                                <span class="badge bg-info">
                                    <i class="fas fa-gift me-1"></i> {{ $inquiry->package }}
                                </span>
                            @else
                                <span class="badge bg-secondary">Belum pilih paket</span>
                            @endif
                        </td>
                        <td>
                            {{ $inquiry->wedding_date ? $inquiry->wedding_date->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($inquiry->is_read)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Sudah Dibaca
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-clock"></i> Belum Dibaca
                                </span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $inquiry->created_at->format('d/m/Y H:i') }}</small>
                        </td>
                        <td class="table-actions">
                            <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <form action="{{ route('admin.inquiries.destroy', $inquiry) }}" method="POST" 
                                  style="display: inline-block;" 
                                  onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Belum ada pesan masuk</h5>
                            <p class="text-muted">Belum ada klien yang mengirim pesan melalui form kontak.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>

<style>
    .table-actions .btn {
        margin: 0 2px;
    }
    
    .table-warning {
        background-color: #fff3cd !important;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 5px 10px;
    }
    
    .btn-sm {
        padding: 5px 10px;
    }
</style>
@endsection