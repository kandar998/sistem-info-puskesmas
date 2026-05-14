@extends('admin.layouts.admin')

@section('title', 'Jadwal Pemeriksaan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-calendar-check me-2"></i>Jadwal Pemeriksaan
            </h1>
            <p class="text-muted small">Kelola jadwal pemeriksaan pasien per poli</p>
        </div>
        <a href="{{ route('admin.jadwal-pemeriksaan.create') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small text-white-50 mb-1">Total Jadwal</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalJadwal }}</h3>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small text-white-50 mb-1">Jumlah Poli</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalPoli }}</h3>
                        </div>
                        <i class="fas fa-hospital fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small text-white-50 mb-1">Jumlah Dokter</h6>
                            <h3 class="mb-0 fw-bold">{{ $totalDokter }}</h3>
                        </div>
                        <i class="fas fa-user-md fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0">
                            <i class="fas fa-search text-primary"></i>
                        </span>
                        <input type="text" class="form-control border-0 bg-light" id="searchInput"
                               placeholder="Cari poli atau dokter..." style="box-shadow: none;">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select border-0 bg-light" id="poliFilter">
                        <option value="">Semua Poli</option>
                        @foreach($jadwals->pluck('poli')->unique() as $poli)
                            <option value="{{ $poli }}">{{ $poli }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select border-0 bg-light" id="hariFilter">
                        <option value="">Semua Hari</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                        <i class="fas fa-redo-alt me-2"></i>Reset
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Cards -->
    <div class="row" id="scheduleCards">
        @forelse($jadwals as $index => $jadwal)
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4 schedule-item"
             data-poli="{{ $jadwal->poli }}"
             data-hari="{{ $jadwal->hari }}"
             data-dokter="{{ strtolower($jadwal->dokter) }}"
             style="animation-delay: {{ $index * 0.05 }}s;">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-0">
                    <!-- Header dengan warna berdasarkan poli -->
                    <div class="p-3 text-white rounded-top" style="background: linear-gradient(135deg, {{ getPoliColor($jadwal->poli) }});">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">{{ $jadwal->poli }}</h5>
                            <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                <i class="far fa-clock me-1"></i>{{ substr($jadwal->jam_mulai, 0, 5) }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle bg-light-primary me-3">
                                <i class="fas fa-user-md text-primary"></i>
                            </div>
                            <div>
                                <p class="small text-muted mb-0">Dokter</p>
                                <h6 class="fw-bold mb-0">{{ $jadwal->dokter }}</h6>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="info-box p-2 bg-light rounded">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                    <span class="small">{{ $jadwal->hari }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box p-2 bg-light rounded">
                                    <i class="fas fa-hourglass-end text-primary me-1"></i>
                                    <span class="small">{{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-box p-2 bg-light rounded">
                                    <i class="fas fa-users text-primary me-1"></i>
                                    <span class="small">Kuota: {{ $jadwal->kuota }} pasien</span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('admin.jadwal-pemeriksaan.edit', $jadwal->id) }}"
                               class="btn btn-sm btn-outline-warning rounded-pill px-3">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                    onclick="confirmDelete('{{ $jadwal->id }}', '{{ $jadwal->poli }}')">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                            <form id="delete-form-{{ $jadwal->id }}"
                                  action="{{ route('admin.jadwal-pemeriksaan.destroy', $jadwal->id) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h5>Belum Ada Jadwal Pemeriksaan</h5>
                        <p class="text-muted">Klik tombol "Tambah Jadwal" untuk membuat jadwal baru.</p>
                        <a href="{{ route('admin.jadwal-pemeriksaan.create') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Gradient backgrounds */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #396afc 0%, #2948ff 100%);
    }

    .text-white-50 {
        color: rgba(255,255,255,0.7);
    }

    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .bg-light-primary {
        background: rgba(13, 110, 253, 0.1);
    }

    .info-box {
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .info-box:hover {
        background: #e9ecef !important;
        transform: translateX(5px);
    }

    .empty-state {
        opacity: 0.7;
    }

    .schedule-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    .schedule-item:hover {
        transform: translateY(-5px);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .badge {
        font-size: 0.8rem;
        font-weight: 500;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .btn-sm.rounded-pill {
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
        }

        .info-box {
            font-size: 0.85rem;
        }

        .avatar-circle {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        h5 {
            font-size: 1rem;
        }

        .container-fluid {
            padding: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .schedule-item {
            animation-delay: 0s !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const poliFilter = document.getElementById('poliFilter');
        const hariFilter = document.getElementById('hariFilter');

        if (searchInput) {
            searchInput.addEventListener('keyup', filterCards);
        }
        if (poliFilter) {
            poliFilter.addEventListener('change', filterCards);
        }
        if (hariFilter) {
            hariFilter.addEventListener('change', filterCards);
        }
    });

    function filterCards() {
        const searchInput = document.getElementById('searchInput');
        const poliFilter = document.getElementById('poliFilter');
        const hariFilter = document.getElementById('hariFilter');

        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const poliValue = poliFilter ? poliFilter.value : '';
        const hariValue = hariFilter ? hariFilter.value : '';

        const cards = document.querySelectorAll('.schedule-item');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardPoli = card.dataset.poli || '';
            const cardHari = card.dataset.hari || '';
            const cardDokter = card.dataset.dokter || '';
            const cardText = card.textContent.toLowerCase();

            let showCard = true;

            if (searchTerm) {
                const poliMatch = cardPoli.toLowerCase().includes(searchTerm);
                const dokterMatch = cardDokter.includes(searchTerm);
                const textMatch = cardText.includes(searchTerm);

                if (!poliMatch && !dokterMatch && !textMatch) {
                    showCard = false;
                }
            }

            if (poliValue && cardPoli !== poliValue) {
                showCard = false;
            }

            if (hariValue && cardHari !== hariValue) {
                showCard = false;
            }

            card.style.display = showCard ? 'block' : 'none';
            if (showCard) visibleCount++;
        });

        // Handle no results message
        let noResultsMessage = document.getElementById('noResultsMessage');

        if (visibleCount === 0) {
            if (!noResultsMessage) {
                const scheduleCards = document.getElementById('scheduleCards');
                if (scheduleCards) {
                    const message = document.createElement('div');
                    message.id = 'noResultsMessage';
                    message.className = 'col-12 text-center py-5';
                    message.innerHTML = `
                        <div class="empty-state">
                            <i class="fas fa-search fa-4x text-muted mb-3"></i>
                            <h5>Tidak Ada Hasil</h5>
                            <p class="text-muted">Tidak ditemukan jadwal yang sesuai dengan filter Anda.</p>
                            <button class="btn btn-primary rounded-pill px-4" onclick="resetFilters()">
                                <i class="fas fa-redo-alt me-2"></i>Reset Filter
                            </button>
                        </div>
                    `;
                    scheduleCards.appendChild(message);
                }
            }
        } else if (noResultsMessage) {
            noResultsMessage.remove();
        }
    }

    function resetFilters() {
        const searchInput = document.getElementById('searchInput');
        const poliFilter = document.getElementById('poliFilter');
        const hariFilter = document.getElementById('hariFilter');

        if (searchInput) searchInput.value = '';
        if (poliFilter) poliFilter.value = '';
        if (hariFilter) hariFilter.value = '';

        filterCards();
    }

    function confirmDelete(id, poli) {
        if (confirm(`Apakah Anda yakin ingin menghapus jadwal ${poli}?`)) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush

@php
function getPoliColor($poli) {
    $colors = [
        'Umum' => '#0d6efd, #0b5ed7',
        'Gigi' => '#198754, #157347',
        'Anak' => '#ffc107, #ffca2c',
        'KB' => '#dc3545, #bb2d3b',
        'Lansia' => '#6f42c1, #6610f2',
        'Mata' => '#17a2b8, #138496',
        'THT' => '#fd7e14, #dc6c12',
        'Kulit' => '#20c997, #1ba87e',
        'Saraf' => '#6610f2, #520dc2',
        'Jantung' => '#e83e8c, #d4337c',
    ];
    return $colors[$poli] ?? '#0d6efd, #0b5ed7';
}
@endphp
