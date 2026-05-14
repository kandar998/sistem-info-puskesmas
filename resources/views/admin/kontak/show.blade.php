@extends('admin.layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-envelope-open-text me-2"></i>Detail Pesan
        </h1>
        <div>
            <a href="{{ route('admin.kontak.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            @if($kontak->status == 'belum_dibaca')
            <button class="btn btn-success btn-sm" onclick="markAsRead({{ $kontak->id }})">
                <i class="fas fa-check me-2"></i>Tandai Dibaca
            </button>
            @endif
            <button class="btn btn-primary btn-sm" onclick="replyMessage()">
                <i class="fas fa-reply me-2"></i>Balas
            </button>
            <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $kontak->id }})">
                <i class="fas fa-trash me-2"></i>Hapus
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Detail Pesan -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-envelope me-2"></i>Isi Pesan
                    </h6>
                    <div>
                        <span class="badge bg-{{ $kontak->status == 'belum_dibaca' ? 'warning' : 'success' }} py-2 px-3">
                            <i class="fas fa-{{ $kontak->status == 'belum_dibaca' ? 'clock' : 'check-circle' }} me-1"></i>
                            {{ $kontak->status == 'belum_dibaca' ? 'Belum Dibaca' : 'Sudah Dibaca' }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">{{ $kontak->nama }}</h5>
                                <small class="text-muted">ID Pesan: #{{ $kontak->id }}</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <a href="mailto:{{ $kontak->email }}" class="text-decoration-none">
                                        {{ $kontak->email }}
                                    </a>
                                </div>
                                @if($kontak->telepon)
                                <div class="d-flex align-items-center">
                                    <i class="fab fa-whatsapp text-success me-2"></i>
                                    <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $kontak->telepon) }}" target="_blank" class="text-decoration-none">
                                        {{ $kontak->telepon }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="text-muted">
                                    <i class="fas fa-calendar me-2"></i>{{ $kontak->created_at->format('d F Y') }}
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-clock me-2"></i>{{ $kontak->created_at->format('H:i') }} WITA
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mt-4">
                            <h6 class="fw-bold mb-3">Pesan:</h6>
                            <div class="bg-light p-4 rounded-3" style="white-space: pre-line;">
                                {{ $kontak->pesan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Pengirim -->
        <div class="col-lg-4">
            <!-- Kartu Info Pengirim -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pengirim
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <h5>{{ $kontak->nama }}</h5>
                        <p class="text-muted mb-0">Pengirim Pesan</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:{{ $kontak->email }}" class="text-decoration-none">
                                {{ $kontak->email }}
                            </a>
                        </div>
                    </div>

                    @if($kontak->telepon)
                    <div class="mb-3">
                        <label class="text-muted small">Telepon / WhatsApp</label>
                        <div class="d-flex align-items-center">
                            <i class="fab fa-whatsapp text-success me-2"></i>
                            <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $kontak->telepon) }}" target="_blank" class="text-decoration-none">
                                {{ $kontak->telepon }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="text-muted small">Dikirim Pada</label>
                        <div>
                            <i class="fas fa-calendar me-2"></i>{{ $kontak->created_at->format('d/m/Y') }}
                            <span class="mx-2">|</span>
                            <i class="fas fa-clock me-1"></i>{{ $kontak->created_at->format('H:i') }}
                        </div>
                    </div>

                    @if($kontak->updated_at != $kontak->created_at)
                    <div class="mb-3">
                        <label class="text-muted small">Status Dibaca</label>
                        <div>
                            @if($kontak->status == 'sudah_dibaca')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Dibaca pada {{ $kontak->updated_at->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Aksi Cepat -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $kontak->email }}" class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Balas via Email
                        </a>
                        @if($kontak->telepon)
                        <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $kontak->telepon) }}?text=Halo%20{{ urlencode($kontak->nama) }}%2C%20saya%20dari%20Puskesmas%20Katoi%20menanggapi%20pesan%20Anda..."
                           target="_blank"
                           class="btn btn-success">
                            <i class="fab fa-whatsapp me-2"></i>Balas via WhatsApp
                        </a>
                        @endif
                        <button class="btn btn-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Cetak Pesan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Delete -->
<form id="delete-form-{{ $kontak->id }}" action="{{ route('admin.kontak.destroy', $kontak->id) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
    .bg-light {
        background-color: #f8f9fa !important;
    }

    .rounded-3 {
        border-radius: 12px !important;
    }

    hr {
        margin: 1.5rem 0;
    }

    @media (max-width: 768px) {
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .btn-group .btn {
            flex: 1;
        }

        .text-md-end {
            text-align: left !important;
            margin-top: 10px;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Pesan?',
        text: "Pesan yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function markAsRead(id) {
    Swal.fire({
        title: 'Tandai Dibaca?',
        text: "Tandai pesan ini sudah dibaca?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, tandai',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("admin.kontak.mark-read", $kontak->id) }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pesan ditandai sudah dibaca',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Gagal mengupdate status pesan. Silakan coba lagi.'
                    });
                }
            });
        }
    });
}

function replyMessage() {
    Swal.fire({
        title: 'Balas Pesan',
        html: `
            <form id="replyForm" class="text-start">
                <div class="mb-3">
                    <label class="form-label">Email Tujuan</label>
                    <input type="email" class="form-control" value="{{ $kontak->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subjek</label>
                    <input type="text" class="form-control" value="Re: Pesan dari Website Puskesmas Katoi" id="subject">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pesan Balasan</label>
                    <textarea class="form-control" rows="5" id="replyMessage" placeholder="Tulis pesan balasan Anda..."></textarea>
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Kirim Balasan',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('replyMessage').value;

            if (!message) {
                Swal.showValidationMessage('Pesan balasan tidak boleh kosong');
                return false;
            }
            if (!subject) {
                Swal.showValidationMessage('Subjek tidak boleh kosong');
                return false;
            }

            return { subject, message };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Buka default email client
            window.location.href = `mailto:{{ $kontak->email }}?subject=${encodeURIComponent(result.value.subject)}&body=${encodeURIComponent(result.value.message)}`;

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Aplikasi email akan terbuka untuk mengirim balasan',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
}
</script>
@endpush
