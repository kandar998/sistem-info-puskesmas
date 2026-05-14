@extends('admin.layouts.admin')

@section('title', 'Edit Status Pelayanan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Status Pelayanan
        </h1>
        <div>
            <a href="{{ route('admin.pelayanan.show', $pelayanan->id) }}" class="btn btn-info btn-sm">
                <i class="fas fa-eye me-2"></i>Detail
            </a>
            <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Status
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pelayanan.update', $pelayanan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status Pelayanan <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ old('status', $pelayanan->status) == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="diproses" {{ old('status', $pelayanan->status) == 'diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                                <option value="selesai" {{ old('status', $pelayanan->status) == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="ditolak" {{ old('status', $pelayanan->status) == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="catatan_admin" class="form-control @error('catatan_admin') is-invalid @enderror"
                                      rows="4" placeholder="Masukkan catatan untuk pasien...">{{ old('catatan_admin', $pelayanan->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Catatan ini akan dilihat oleh pasien saat mengecek status</small>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Status
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
                        <i class="fas fa-info-circle me-2"></i>Informasi Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td width="40%">No RM</td>
                            <td><strong>{{ $pelayanan->no_rm }}</strong></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ $pelayanan->nama }}</td>
                        </tr>
                        <tr>
                            <td>Poli Tujuan</td>
                            <td>{{ $pelayanan->poli_tujuan }}</td>
                        </tr>
                        <tr>
                            <td>Tgl Periksa</td>
                            <td>{{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>Status Saat Ini</td>
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
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Riwayat Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $pelayanan->created_at->format('d/m/Y H:i') }}</div>
                            <div class="timeline-content">
                                <span class="badge bg-secondary">Daftar</span>
                                <small class="text-muted d-block">Pasien mendaftar online</small>
                            </div>
                        </div>
                        @if($pelayanan->updated_at != $pelayanan->created_at)
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $pelayanan->updated_at->format('d/m/Y H:i') }}</div>
                            <div class="timeline-content">
                                <span class="badge bg-primary">Update</span>
                                <small class="text-muted d-block">Status diperbarui</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 20px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
        padding-left: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #007bff;
        border: 2px solid white;
    }
    .timeline-date {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .timeline-content {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
    }
</style>
@endpush
