@extends('admin.layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-envelope me-2"></i>Pesan Masuk
        </h1>
        <div class="d-flex gap-2">
            <button class="btn btn-success btn-sm" onclick="exportData()">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </button>
            <button class="btn btn-secondary btn-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-envelope fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Pesan</h6>
                            <h3 class="mb-0">{{ $totalPesan ?? $kontaks->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Belum Dibaca</h6>
                            <h3 class="mb-0">{{ $belumDibaca ?? $kontaks->where('status', 'belum_dibaca')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Sudah Dibaca</h6>
                            <h3 class="mb-0">{{ $sudahDibaca ?? $kontaks->where('status', 'sudah_dibaca')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="fas fa-calendar-week fa-2x text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Minggu Ini</h6>
                            <h3 class="mb-0">{{ $mingguIni ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Pesan
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.kontak.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="belum_dibaca" {{ request('status') == 'belum_dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="sudah_dibaca" {{ request('status') == 'sudah_dibaca' ? 'selected' : '' }}>Sudah Dibaca</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pencarian</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Nama/Email..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Pesan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Pesan Masuk
            </h6>
            <span class="badge bg-primary">Total: {{ $kontaks->total() }} Pesan</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Status</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kontaks as $index => $kontak)
                        <tr class="{{ $kontak->status == 'belum_dibaca' ? 'table-warning' : '' }}">
                            <td>{{ $kontaks->firstItem() + $index }}</td>
                            <td>
                                @if($kontak->status == 'belum_dibaca')
                                    <span class="badge bg-warning text-dark py-2 px-3">
                                        <i class="fas fa-clock me-1"></i>Belum Dibaca
                                    </span>
                                @else
                                    <span class="badge bg-success py-2 px-3">
                                        <i class="fas fa-check-circle me-1"></i>Sudah Dibaca
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $kontak->nama }}</div>
                                <small class="text-muted">ID: #{{ $kontak->id }}</small>
                            </td>
                            <td>
                                <a href="mailto:{{ $kontak->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1 text-primary"></i>{{ $kontak->email }}
                                </a>
                            </td>
                            <td>
                                @if($kontak->telepon)
                                    <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $kontak->telepon) }}" target="_blank" class="text-decoration-none">
                                        <i class="fab fa-whatsapp me-1 text-success"></i>{{ $kontak->telepon }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;">
                                    {{ Str::limit($kontak->pesan, 50) }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $kontak->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $kontak->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.kontak.show', $kontak->id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($kontak->status == 'belum_dibaca')
                                    <button type="button"
                                            class="btn btn-success btn-sm mark-read"
                                            data-id="{{ $kontak->id }}"
                                            title="Tandai Dibaca"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete({{ $kontak->id }})"
                                            title="Hapus"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $kontak->id }}"
                                      action="{{ route('admin.kontak.destroy', $kontak->id) }}"
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-envelope-open fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum Ada Pesan</h5>
                                    <p class="text-muted">Belum ada pesan yang masuk dari pengunjung.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Menampilkan {{ $kontaks->firstItem() ?? 0 }} - {{ $kontaks->lastItem() ?? 0 }}
                    dari {{ $kontaks->total() }} data
                </div>
                <div>
                    {{ $kontaks->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .empty-state {
        padding: 40px 20px;
    }

    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }

    .badge {
        font-weight: 500;
    }

    .table-warning {
        --bs-table-bg: #fff3cd;
        border-left: 4px solid #ffc107;
    }

    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table {
            font-size: 0.85rem;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .btn-group .btn {
            margin: 0;
            border-radius: 4px !important;
        }

        .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Mark as read
    $('.mark-read').on('click', function() {
        const id = $(this).data('id');
        const button = $(this);
        const row = button.closest('tr');

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
                    url: '{{ route("admin.kontak.mark-read", $kontak->id ?? "") }}'.replace('//', '/'),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update row
                            row.removeClass('table-warning');

                            // Update status badge
                            const statusCell = row.find('td:eq(1)');
                            statusCell.html('<span class="badge bg-success py-2 px-3"><i class="fas fa-check-circle me-1"></i>Sudah Dibaca</span>');

                            // Remove mark read button
                            button.remove();

                            // Show success notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Pesan ditandai sudah dibaca',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal mengupdate status pesan'
                        });
                    }
                });
            }
        });
    });
});

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

function exportData() {
    // Ambil parameter filter dari URL saat ini
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status') || '';
    const tanggal_mulai = urlParams.get('tanggal_mulai') || '';
    const tanggal_akhir = urlParams.get('tanggal_akhir') || '';
    const search = urlParams.get('search') || '';

    // Bangun URL export dengan parameter filter
    let exportUrl = '{{ route("admin.kontak.export") }}';
    let params = [];

    if (status) params.push('status=' + encodeURIComponent(status));
    if (tanggal_mulai) params.push('tanggal_mulai=' + encodeURIComponent(tanggal_mulai));
    if (tanggal_akhir) params.push('tanggal_akhir=' + encodeURIComponent(tanggal_akhir));
    if (search) params.push('search=' + encodeURIComponent(search));

    if (params.length > 0) {
        exportUrl += '?' + params.join('&');
    }

    // Redirect ke URL export
    window.location.href = exportUrl;
}
</script>
@endpush
