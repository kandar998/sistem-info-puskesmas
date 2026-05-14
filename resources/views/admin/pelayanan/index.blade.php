@extends('admin.layouts.admin')

@section('title', 'Data Pelayanan Online ')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Data Pelayanan Online Puskesmas Katoi
        </h1>
        <div>
            <button class="btn btn-success btn-sm" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Data
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pelayanan.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                        <input type="text" name="search" class="form-control" placeholder="Nama/NIK/No RM" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Daftar Pelayanan
            </h6>
            <span class="badge bg-primary">Total: {{ $pelayanans->total() }} Data</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>No RM</th>
                            <th>Nama Pasien</th>
                            <th>NIK</th>
                            <th>Poli Tujuan</th>
                            <th>Tgl Periksa</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelayanans as $index => $pelayanan)
                        <tr>
                            <td>{{ $pelayanans->firstItem() + $index }}</td>
                            <td><span class="badge bg-secondary">{{ $pelayanan->no_rm }}</span></td>
                            <td>{{ $pelayanan->nama }}</td>
                            <td>{{ $pelayanan->nik }}</td>
                            <td>{{ $pelayanan->poli_tujuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d/m/Y') }}</td>
                            <td>
                                @if($pelayanan->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($pelayanan->status == 'diproses')
                                    <span class="badge bg-info">Diproses</span>
                                @elseif($pelayanan->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($pelayanan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.pelayanan.show', $pelayanan->id) }}"
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pelayanan.edit', $pelayanan->id) }}"
                                       class="btn btn-warning btn-sm" title="Edit Status">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="confirmDelete('{{ $pelayanan->id }}')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $pelayanan->id }}"
                                      action="{{ route('admin.pelayanan.destroy', $pelayanan->id) }}"
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pelayanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Menampilkan {{ $pelayanans->firstItem() ?? 0 }} - {{ $pelayanans->lastItem() ?? 0 }}
                    dari {{ $pelayanans->total() }} data
                </div>
                <div>
                    {{ $pelayanans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Auto submit filter saat status berubah
document.querySelector('select[name="status"]').addEventListener('change', function() {
    this.form.submit();
});

// Auto submit filter saat tanggal berubah
document.querySelector('input[name="tanggal_mulai"]').addEventListener('change', function() {
    this.form.submit();
});
document.querySelector('input[name="tanggal_akhir"]').addEventListener('change', function() {
    this.form.submit();
});
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
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
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
