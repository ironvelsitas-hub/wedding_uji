@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-star me-2"></i> Manajemen Testimoni
    </h1>
    <div>
        <span class="badge bg-warning me-2">
            <i class="fas fa-clock"></i> Pending: {{ $testimonials->where('status', 'pending')->count() }}
        </span>
        <span class="badge bg-info me-2">
            <i class="fas fa-user-check"></i> Perlu Verifikasi: {{ $testimonials->where('is_verified', false)->count() }}
        </span>
        <span class="badge bg-success">
            <i class="fas fa-check-circle"></i> Total: {{ $testimonials->total() }}
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
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Foto</th>
                        <th>Nama Klien</th>
                        <th>Pengirim</th>
                        <th>Email / Telepon</th>
                        <th>Rating</th>
                        <th>Testimoni</th>
                        <th>Status</th>
                        <th>Status Verifikasi</th>
                        <th>Featured</th>
                        <th>Waktu Submit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $testimonial)
                    <tr class="{{ $testimonial->status == 'pending' ? 'table-warning' : '' }}">
                        <td>{{ $testimonial->id }}</td>
                        <td>
                            @if($testimonial->photo)
                                <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                     width="50" height="50" class="rounded-circle" style="object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                         </td>
                        <td>
                            <strong>{{ $testimonial->client_name }}</strong>
                            @if($testimonial->couple_name)
                                <br><small class="text-muted">({{ $testimonial->couple_name }})</small>
                            @endif
                            @if($testimonial->status == 'pending')
                                <br><span class="badge bg-danger mt-1">Baru</span>
                            @endif
                         </td>
                        <td>
                            @if($testimonial->email)
                                <span class="badge bg-info">
                                    <i class="fas fa-user"></i> User
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user-shield"></i> Admin
                                </span>
                            @endif
                            <br>
                            <small class="text-muted">
                                @if($testimonial->submitted_at)
                                    <i class="fas fa-clock me-1"></i> {{ $testimonial->submitted_at->diffForHumans() }}
                                @else
                                    <i class="fas fa-calendar me-1"></i> {{ $testimonial->created_at->diffForHumans() }}
                                @endif
                            </small>
                         </td>
                        <td>
                            @if($testimonial->email)
                                <small>{{ $testimonial->email }}</small><br>
                            @endif
                            @if($testimonial->phone)
                                <small class="text-muted">{{ $testimonial->phone }}</small>
                            @endif
                         </td>
                        <td>
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <br><small>{{ $testimonial->rating }}/5</small>
                            </div>
                         </td>
                        <td>{{ Str::limit($testimonial->message, 60) }}</td>
                        <td>
                            <select class="form-select form-select-sm status-select" 
                                    data-id="{{ $testimonial->id }}"
                                    style="width: 120px;">
                                <option value="pending" {{ $testimonial->status == 'pending' ? 'selected' : '' }}>
                                    ⏳ Pending
                                </option>
                                <option value="approved" {{ $testimonial->status == 'approved' ? 'selected' : '' }}>
                                    ✅ Approved
                                </option>
                                <option value="rejected" {{ $testimonial->status == 'rejected' ? 'selected' : '' }}>
                                    ❌ Rejected
                                </option>
                            </select>
                         </td>
                        <td>
                            @if($testimonial->is_verified)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Terverifikasi
                                </span>
                            @else
                                <div>
                                    <span class="badge bg-warning mb-1">
                                        <i class="fas fa-clock"></i> Belum Verifikasi
                                    </span>
                                    <br>
                                    <button class="btn btn-sm btn-info mt-1 verify-btn" data-id="{{ $testimonial->id }}">
                                        <i class="fas fa-check-double"></i> Verifikasi
                                    </button>
                                </div>
                            @endif
                         </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input featured-toggle" type="checkbox" 
                                       data-id="{{ $testimonial->id }}"
                                       {{ $testimonial->is_featured ? 'checked' : '' }}>
                            </div>
                         </td>
                        <td>
                            @if($testimonial->submitted_at)
                                <small>{{ $testimonial->submitted_at->format('d/m/Y H:i') }}</small>
                            @else
                                <small>{{ $testimonial->created_at->format('d/m/Y H:i') }}</small>
                            @endif
                         </td>
                        <td class="table-actions">
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" 
                                    data-bs-target="#viewModal{{ $testimonial->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" 
                                  style="display: inline-block;" 
                                  onsubmit="return confirm('Yakin ingin menghapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                         </td>
                     </tr>
                    
                    <!-- Modal View -->
                    <div class="modal fade" id="viewModal{{ $testimonial->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-gold text-white">
                                    <h5 class="modal-title">Detail Testimoni - {{ $testimonial->client_name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            @if($testimonial->photo)
                                                <img src="{{ asset('storage/' . $testimonial->photo) }}" 
                                                     class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                     style="width: 150px; height: 150px;">
                                                    <i class="fas fa-user fa-3x text-white"></i>
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $testimonial->rating)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @else
                                                        <i class="far fa-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p><strong>Rating:</strong> {{ $testimonial->rating }}/5</p>
                                            @if(!$testimonial->is_verified)
                                                <button class="btn btn-success btn-sm w-100 verify-btn-modal" data-id="{{ $testimonial->id }}">
                                                    <i class="fas fa-check-double me-2"></i> Verifikasi & Setujui
                                                </button>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <h6>Testimoni:</h6>
                                                <p class="fst-italic">"{{ $testimonial->message }}"</p>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong><i class="fas fa-user me-2"></i> Nama:</strong><br>
                                                    {{ $testimonial->client_name }}</p>
                                                    
                                                    @if($testimonial->couple_name)
                                                    <p><strong><i class="fas fa-heart me-2"></i> Pasangan:</strong><br>
                                                    {{ $testimonial->couple_name }}</p>
                                                    @endif
                                                    
                                                    @if($testimonial->email)
                                                    <p><strong><i class="fas fa-envelope me-2"></i> Email:</strong><br>
                                                    {{ $testimonial->email }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($testimonial->phone)
                                                    <p><strong><i class="fas fa-phone me-2"></i> Telepon:</strong><br>
                                                    {{ $testimonial->phone }}</p>
                                                    @endif
                                                    
                                                    @if($testimonial->wedding_date)
                                                    <p><strong><i class="fas fa-calendar me-2"></i> Tanggal Pernikahan:</strong><br>
                                                    {{ date('d F Y', strtotime($testimonial->wedding_date)) }}</p>
                                                    @endif
                                                    
                                                    @if($testimonial->venue)
                                                    <p><strong><i class="fas fa-map-marker-alt me-2"></i> Venue:</strong><br>
                                                    {{ $testimonial->venue }}</p>
                                                    @endif
                                                    
                                                    @if($testimonial->package_used)
                                                    <p><strong><i class="fas fa-gift me-2"></i> Paket:</strong><br>
                                                    {{ $testimonial->package_used }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            @if($testimonial->video_url)
                                            <div class="mt-3">
                                                <strong><i class="fas fa-video me-2"></i> Video Testimoni:</strong>
                                                <div class="ratio ratio-16by9 mt-2">
                                                    <iframe src="{{ $testimonial->video_url }}" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                            @endif
                                            
                                            @if($testimonial->submitted_at)
                                            <div class="alert alert-info mt-3">
                                                <small><i class="fas fa-clock me-1"></i> Dikirim pada: {{ $testimonial->submitted_at->format('d F Y H:i:s') }}</small>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
             </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $testimonials->links() }}
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
    .btn-sm {
        padding: 5px 10px;
    }
    .rating-display {
        white-space: nowrap;
    }
    .bg-gold {
        background: linear-gradient(135deg, #d4af37, #c5a028);
    }
</style>

@push('scripts')
<script>
    // Update status
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', async function() {
            const id = this.dataset.id;
            const status = this.value;
            
            try {
                const response = await fetch(`/admin/testimonials/${id}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                });
                
                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
    
    // Toggle featured
    document.querySelectorAll('.featured-toggle').forEach(toggle => {
        toggle.addEventListener('change', async function() {
            const id = this.dataset.id;
            
            try {
                const response = await fetch(`/admin/testimonials/${id}/toggle-featured`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (!response.ok) {
                    this.checked = !this.checked;
                }
            } catch (error) {
                console.error('Error:', error);
                this.checked = !this.checked;
            }
        });
    });
    
    // Verifikasi testimonial (dari tombol di tabel)
    document.querySelectorAll('.verify-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            
            if (confirm('Verifikasi testimonial ini? Testimonial akan ditampilkan di website setelah diverifikasi.')) {
                try {
                    const response = await fetch(`/admin/testimonials/${id}/verify`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    
                    if (response.ok) {
                        location.reload();
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }
        });
    });
    
    // Verifikasi testimonial (dari modal)
    document.querySelectorAll('.verify-btn-modal').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            
            try {
                const response = await fetch(`/admin/testimonials/${id}/verify`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
@endpush
@endsection