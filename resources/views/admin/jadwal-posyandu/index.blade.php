@extends('admin.layouts.admin')

@section('title', 'Data Jadwal Posyandu')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-child me-2"></i>Data Jadwal Posyandu
        </h1>
        <a href="{{ route('admin.jadwal-posyandu.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small mb-1">Total Jadwal</h6>
                            <h3 class="mb-0">{{ $totalJadwal ?? $jadwals->total() }}</h3>
                        </div>
                        <i class="fas fa-calendar fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small mb-1">Jadwal Mendatang</h6>
                            <h3 class="mb-0">{{ $jadwalMendatang ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="small mb-1">Hari Ini</h6>
                            <h3 class="mb-0">{{ $jadwalHariIni ?? 0 }}</h3>
                        </div>
                        <i class="fas fa-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Data
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.jadwal-posyandu.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        <option value="1" {{ request('bulan') == 1 ? 'selected' : '' }}>Januari</option>
                        <option value="2" {{ request('bulan') == 2 ? 'selected' : '' }}>Februari</option>
                        <option value="3" {{ request('bulan') == 3 ? 'selected' : '' }}>Maret</option>
                        <option value="4" {{ request('bulan') == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ request('bulan') == 5 ? 'selected' : '' }}>Mei</option>
                        <option value="6" {{ request('bulan') == 6 ? 'selected' : '' }}>Juni</option>
                        <option value="7" {{ request('bulan') == 7 ? 'selected' : '' }}>Juli</option>
                        <option value="8" {{ request('bulan') == 8 ? 'selected' : '' }}>Agustus</option>
                        <option value="9" {{ request('bulan') == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ request('bulan') == 10 ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ request('bulan') == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ request('bulan') == 12 ? 'selected' : '' }}>Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @for($tahun = date('Y'); $tahun >= date('Y')-5; $tahun--)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama Posyandu/Lokasi" value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.jadwal-posyandu.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Daftar Jadwal Posyandu
            </h6>
            <span class="badge bg-primary">Total: {{ $jadwals->total() }} Data</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Posyandu</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $index => $jadwal)
                        <tr>
                            <td>{{ $jadwals->firstItem() + $index }}</td>
                            <td>{{ $jadwal->nama_posyandu }}</td>
                            <td>{{ $jadwal->lokasi }}</td>
                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</td>
                            <td>
                                @php
                                    $tanggalJadwal = \Carbon\Carbon::parse($jadwal->tanggal);
                                    $hariIni = \Carbon\Carbon::today();
                                @endphp

                                @if($tanggalJadwal->isToday())
                                    <span class="badge bg-success">Hari Ini</span>
                                @elseif($tanggalJadwal->isFuture())
                                    <span class="badge bg-primary">Mendatang</span>
                                @else
                                    <span class="badge bg-secondary">Terlewat</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.jadwal-posyandu.edit', $jadwal->id) }}"
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $jadwal->id }}')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $jadwal->id }}"
                                      action="{{ route('admin.jadwal-posyandu.destroy', $jadwal->id) }}"
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data jadwal posyandu</p>
                                <a href="{{ route('admin.jadwal-posyandu.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $jadwals->firstItem() ?? 0 }} - {{ $jadwals->lastItem() ?? 0 }}
                    dari {{ $jadwals->total() }} data
                </div>
                <div>
                    {{ $jadwals->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }
    .opacity-50 {
        opacity: 0.5;
    }
    @media (max-width: 768px) {
        .table {
            font-size: 0.85rem;
        }
        .btn-group {
            display: flex;
            flex-direction: column;
        }
        .btn-group .btn {
            margin-bottom: 2px;
            border-radius: 0.25rem !important;
        }
    }
</style>
@endpush
