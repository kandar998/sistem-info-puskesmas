@extends('admin.layouts.admin')

@section('title', 'Edit Data Struktur')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Data Struktur
        </h1>
        <div>
            <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Data
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.struktur.update', $struktur->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $struktur->nama) }}" placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                   value="{{ old('jabatan', $struktur->jabatan) }}" placeholder="Contoh: Kepala Puskesmas" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $struktur->urutan) }}" min="1" required>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Urutan tampil di halaman depan (semakin kecil semakin atas)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*" id="fotoInput">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>

                            @if($struktur->foto)
                            <div class="mt-3">
                                <p class="mb-2">Foto Saat Ini:</p>
                                <img src="{{ Storage::url($struktur->foto) }}" alt="Foto" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                            @endif

                            <div class="mt-3 text-center" id="previewContainer" style="display: none;">
                                <p class="mb-2">Preview Foto Baru:</p>
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Data
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
                        <i class="fas fa-info-circle me-2"></i>Informasi Data
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td>ID Data</td>
                            <td><strong>#{{ $struktur->id }}</strong></td>
                        </tr>
                        <tr>
                            <td>Dibuat Pada</td>
                            <td>{{ $struktur->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Terakhir Update</td>
                            <td>{{ $struktur->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Perubahan akan langsung tampil di halaman depan website.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(e.target.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endpush
