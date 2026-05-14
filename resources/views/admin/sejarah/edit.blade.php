@extends('admin.layouts.admin')

@section('title', 'Edit Sejarah Puskesmas')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>Edit Sejarah Puskesmas
        </h1>
        <a href="{{ route('home') }}#sejarah" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-eye me-2"></i>Lihat Halaman Depan
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Sejarah
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sejarah.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Konten Sejarah <span class="text-danger">*</span></label>
                            <textarea name="konten" class="form-control @error('konten') is-invalid @enderror"
                                      rows="12" required placeholder="Tuliskan sejarah berdirinya Puskesmas Katoi...">{{ old('konten', $sejarah->konten ?? '') }}</textarea>
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Gunakan teks biasa, minimal 100 karakter untuk SEO</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Terakhir Diperbarui</label>
                        <div class="h6">
                            @if($sejarah && $sejarah->updated_at)
                                {{ $sejarah->updated_at->format('d F Y H:i') }}
                            @else
                                Belum pernah diperbarui
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Jumlah Karakter</label>
                        <div class="h6" id="charCount">
                            {{ strlen($sejarah->konten ?? '') }} karakter
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips:</strong> Tuliskan sejarah secara kronologis dan lengkap untuk memberikan informasi yang baik kepada pengunjung.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Hitung karakter
    const textarea = document.querySelector('textarea[name="konten"]');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' karakter';
        });
    }
</script>
@endpush
