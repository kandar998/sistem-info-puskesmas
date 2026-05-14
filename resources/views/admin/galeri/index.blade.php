@extends('admin.layouts.admin')

@section('title', 'Manajemen Galeri')

@push('styles')
<style>
    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        aspect-ratio: 1/1;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.5s;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 20px 15px 15px;
        transform: translateY(100%);
        transition: all 0.3s;
    }

    .gallery-item:hover .gallery-overlay {
        transform: translateY(0);
    }

    .gallery-actions {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
        opacity: 0;
        transition: all 0.3s;
    }

    .gallery-item:hover .gallery-actions {
        opacity: 1;
    }

    .video-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255,0,0,0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 10;
    }

    .filter-btn {
        border: 1px solid #dee2e6;
        background: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .filter-btn.active {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .filter-btn:hover {
        background: #e9ecef;
    }

    .filter-btn.active:hover {
        background: #0b5ed7;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-images me-2"></i>Manajemen Galeri
        </h1>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Tambah Galeri
        </a>
    </div>

    <!-- Filter Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <button class="filter-btn active" data-filter="all">Semua</button>
                        <button class="filter-btn" data-filter="foto">Foto</button>
                        <button class="filter-btn" data-filter="video">Video</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4" id="galleryGrid">
        @forelse($galeris as $galeri)
        <div class="col-lg-3 col-md-4 col-sm-6 gallery-item-wrapper" data-type="{{ $galeri->tipe }}">
            <div class="gallery-item">
                @if($galeri->tipe == 'foto')
                    <img src="{{ Storage::url($galeri->file) }}" alt="{{ $galeri->judul }}">
                    <span class="video-badge">
                        <i class="fas fa-camera"></i> Foto
                    </span>
                @else
                    <img src="{{ $galeri->thumbnail ? Storage::url($galeri->thumbnail) : asset('images/video-thumb.jpg') }}"
                         alt="{{ $galeri->judul }}">
                    <span class="video-badge">
                        <i class="fas fa-play"></i> Video
                    </span>
                @endif

                <div class="gallery-overlay">
                    <h6 class="mb-1 text-truncate">{{ $galeri->judul }}</h6>
                    <small>{{ $galeri->created_at->format('d M Y') }}</small>
                    @if($galeri->deskripsi)
                        <p class="small mb-0 text-truncate">{{ $galeri->deskripsi }}</p>
                    @endif
                </div>

                <div class="gallery-actions">
                    <div class="btn-group" role="group">
                        @if($galeri->tipe == 'video')
                            <a href="{{ $galeri->file }}"
                               class="btn btn-sm btn-info"
                               target="_blank"
                               title="Tonton Video">
                                <i class="fas fa-play"></i>
                            </a>
                        @else
                            <a href="{{ Storage::url($galeri->file) }}"
                               class="btn btn-sm btn-info"
                               target="_blank"
                               title="Lihat Foto">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                        <a href="{{ route('admin.galeri.edit', $galeri->id) }}"
                           class="btn btn-sm btn-warning"
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.galeri.destroy', $galeri->id) }}"
                              method="POST"
                              class="d-inline"
                              id="delete-form-{{ $galeri->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    class="btn btn-sm btn-danger"
                                    onclick="confirmDelete(event, 'delete-form-{{ $galeri->id }}')"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-images fa-5x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada galeri</h5>
                <p class="text-muted mb-4">Tambahkan foto atau video untuk mempercantik galeri Anda</p>
                <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Galeri Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $galeris->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item-wrapper');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;

            galleryItems.forEach(item => {
                if (filter === 'all' || item.dataset.type === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Search functionality (optional)
    document.addEventListener('keyup', function(e) {
        if (e.target.id === 'searchGallery') {
            const searchText = e.target.value.toLowerCase();

            galleryItems.forEach(item => {
                const title = item.querySelector('.gallery-overlay h6').textContent.toLowerCase();
                const type = item.dataset.type;
                const currentFilter = document.querySelector('.filter-btn.active').dataset.filter;

                if (currentFilter === 'all' || type === currentFilter) {
                    if (title.includes(searchText)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        }
    });
</script>
@endpush
