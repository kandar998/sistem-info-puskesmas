@extends('admin.layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-newspaper me-2"></i>Manajemen Berita
        </h1>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Berita
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Berita</h6>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Cari berita...">
                            <button class="btn btn-primary btn-sm" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <select class="form-select form-select-sm" style="width: 120px;" id="statusFilter">
                            <option value="">Semua</option>
                            <option value="publish">Publish</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="beritaTable">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">No</th>
                                    <th width="80">Gambar</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($beritas as $index => $berita)
                                <tr>
                                    <td>{{ $beritas->firstItem() + $index }}</td>
                                    <td>
                                        @if($berita->gambar)
                                            <img src="{{ Storage::url($berita->gambar) }}"
                                                 alt="{{ $berita->judul }}"
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px; border-radius: 5px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $berita->judul }}</strong><br>
                                        <small class="text-muted">{{ Str::limit(strip_tags($berita->konten), 50) }}</small>
                                    </td>
                                    <td>{{ $berita->tanggal->format('d/m/Y') }}</td>
                                    <td>
                                        @if($berita->status == 'publish')
                                            <span class="badge bg-success">Publish</span>
                                        @else
                                            <span class="badge bg-warning">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('berita.detail', $berita->id) }}"
                                               class="btn btn-sm btn-info"
                                               target="_blank"
                                               title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.berita.edit', $berita->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  id="delete-form-{{ $berita->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="confirmDelete(event, 'delete-form-{{ $berita->id }}')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data berita</p>
                                        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus-circle me-2"></i>Tambah Berita Pertama
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted small">
                            Menampilkan {{ $beritas->firstItem() ?? 0 }} - {{ $beritas->lastItem() ?? 0 }} dari {{ $beritas->total() }} data
                        </div>
                        <div>
                            {{ $beritas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Simple search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    let searchText = this.value.toLowerCase();
    let tableRows = document.querySelectorAll('#beritaTable tbody tr');

    tableRows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchText) ? '' : 'none';
    });
});

// Filter by status
document.getElementById('statusFilter').addEventListener('change', function() {
    let filterValue = this.value.toLowerCase();
    let tableRows = document.querySelectorAll('#beritaTable tbody tr');

    tableRows.forEach(row => {
        if (filterValue === '') {
            row.style.display = '';
        } else {
            let statusCell = row.querySelector('td:nth-child(5) .badge');
            let status = statusCell ? statusCell.textContent.toLowerCase() : '';
            row.style.display = status.includes(filterValue) ? '' : 'none';
        }
    });
});
</script>
@endpush
