@extends('admin.layouts.admin')

@section('title', 'Data Struktur Organisasi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-sitemap me-2"></i>Struktur Organisasi
        </h1>
        <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Data
        </a>
    </div>

    <!-- Sortable Grid -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Struktur Organisasi
            </h6>
            <span class="badge bg-primary">Total: {{ $strukturs->count() }} Data</span>
        </div>
        <div class="card-body">
            <div class="row" id="sortable-grid">
                @forelse($strukturs as $struktur)
                <div class="col-lg-4 col-md-6 mb-4" data-id="{{ $struktur->id }}">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="position-relative">
                                <div class="drag-handle position-absolute top-0 start-0 p-2 text-muted" style="cursor: move;">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>

                                @if($struktur->foto)
                                    <img src="{{ Storage::url($struktur->foto) }}"
                                         alt="{{ $struktur->nama }}"
                                         class="rounded-circle img-fluid mb-3 border border-3 border-primary p-1"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 border border-3 border-primary p-1"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-muted"></i>
                                    </div>
                                @endif
                            </div>

                            <h5 class="card-title">{{ $struktur->nama }}</h5>
                            <p class="card-text text-primary fw-bold">{{ $struktur->jabatan }}</p>

                            <div class="mt-3">
                                <span class="badge bg-secondary">Urutan: {{ $struktur->urutan }}</span>
                            </div>

                            <hr>

                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.struktur.edit', $struktur->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button"
                                        class="btn btn-danger btn-sm"
                                        onclick="confirmDelete('{{ $struktur->id }}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>

                            <form id="delete-form-{{ $struktur->id }}"
                                  action="{{ route('admin.struktur.destroy', $struktur->id) }}"
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data struktur organisasi</h5>
                    <a href="{{ route('admin.struktur.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Data Pertama
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/sortable.min.css">
<style>
    .sortable-ghost {
        opacity: 0.5;
        background: #c8ebfb;
        border: 2px dashed #007bff;
    }
    .sortable-drag {
        opacity: 0.8;
        transform: rotate(2deg);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Sortable Grid
const grid = document.getElementById('sortable-grid');
if (grid) {
    new Sortable(grid, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd: function(evt) {
            const items = [];
            document.querySelectorAll('#sortable-grid > div').forEach((el, index) => {
                items.push({
                    id: el.dataset.id,
                    urutan: index + 1
                });
            });

            // Send to server
            fetch('{{ route("admin.struktur.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: items })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update urutan badges
                    items.forEach(item => {
                        const badge = document.querySelector(`[data-id="${item.id}"] .badge`);
                        if (badge) {
                            badge.textContent = 'Urutan: ' + item.urutan;
                        }
                    });
                }
            });
        }
    });
}
</script>
@endpush
