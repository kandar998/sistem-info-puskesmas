@extends('layouts.app')

@section('title', 'Pelayanan Online')

{{-- DEBUG SECTION --}}
@php
    echo '<!-- DEBUG: jadwalPerPoli count = ' . count($jadwalPerPoli) . ' -->';
    echo '<!-- DEBUG: jadwals count = ' . $jadwals->count() . ' -->';

    if(count($jadwalPerPoli) == 0) {
        echo '<div style="background: #ffcccc; padding: 20px; margin: 20px; border: 2px solid red; border-radius: 5px;">';
        echo '<h3 style="color: red;">⚠️ DEBUG INFO - DATA TIDAK SAMPAI KE VIEW</h3>';
        echo '<p><strong>Total jadwal di database:</strong> ' . App\Models\JadwalPemeriksaan::count() . '</p>';
        echo '<p><strong>jadwals count:</strong> ' . $jadwals->count() . '</p>';
        echo '<p><strong>jadwalPerPoli count:</strong> ' . count($jadwalPerPoli) . '</p>';

        if($jadwals->count() > 0) {
            echo '<h4>Sample data jadwal:</h4>';
            echo '<ul>';
            foreach($jadwals->take(3) as $j) {
                echo '<li>' . $j->poli . ' - ' . $j->hari . ' - ' . $j->dokter . '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
@endphp

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">PELAYANAN ONLINE</h1>
        <p class="lead">Daftar pemeriksaan secara online untuk kemudahan Anda</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Pelayanan Online</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Alert Success -->
@if(session('success'))
<div class="container mt-4" data-aos="fade-down">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<!-- Alert Error -->
@if(session('error'))
<div class="container mt-4" data-aos="fade-down">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<!-- Tampilkan error validasi -->
@if($errors->any())
<div class="container mt-4" data-aos="fade-down">
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
@endif

<!-- Form Pendaftaran -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-lg" data-aos="fade-right">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-file-medical me-2"></i>Formulir Pendaftaran Online</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pelayanan.store') }}" method="POST" id="pelayananForm">
                            @csrf

                            <!-- Data Pribadi -->
                            <h5 class="mb-3 text-primary">A. Data Pribadi</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                           value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                           value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                           value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                           value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d', strtotime('-5 years')) }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                              rows="2" placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                           value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" required>
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Data Pelayanan -->
                            <h5 class="mb-3 text-primary">B. Data Pelayanan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Poli Tujuan <span class="text-danger">*</span></label>
                                    <select name="poli_tujuan" class="form-select @error('poli_tujuan') is-invalid @enderror" id="poli_tujuan" required>
                                        <option value="">-- Pilih Poli --</option>
                                        @forelse($jadwalPerPoli as $poliData)
                                            @php
                                                $hariJadwal = collect($poliData['jadwal'])->pluck('hari')->implode(', ');
                                                $totalKuota = collect($poliData['jadwal'])->sum('kuota');
                                            @endphp
                                            <option value="{{ $poliData['poli'] }}"
                                                    data-jadwal="{{ $hariJadwal }}"
                                                    data-detail='{{ json_encode($poliData['jadwal']) }}'
                                                    {{ old('poli_tujuan') == $poliData['poli'] ? 'selected' : '' }}>
                                                {{ $poliData['poli'] }} ({{ count($poliData['jadwal']) }} jadwal)
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada jadwal tersedia</option>
                                        @endforelse
                                    </select>
                                    @error('poli_tujuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Info Jadwal Poli -->
                                    <div id="info-jadwal-poli" class="mt-2 p-2 bg-light rounded" style="display: none;">
                                        <small class="text-primary fw-bold"><i class="fas fa-info-circle me-1"></i>Jadwal Tersedia:</small>
                                        <div id="jadwal-list" class="mt-1"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Periksa <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_periksa" class="form-control @error('tanggal_periksa') is-invalid @enderror"
                                           id="tanggal_periksa" value="{{ old('tanggal_periksa') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+30 days')) }}" required>
                                    @error('tanggal_periksa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <!-- Info Hari -->
                                    <div id="info-hari" class="mt-2 small text-muted" style="display: none;">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <span id="nama-hari"></span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <!-- Info Kuota -->
                                    <div id="kuota-info" class="mt-2"></div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Keluhan <span class="text-danger">*</span></label>
                                    <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror"
                                              rows="4" placeholder="Jelaskan keluhan yang Anda rasakan..." required>{{ old('keluhan') }}</textarea>
                                    @error('keluhan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya menyatakan bahwa data yang diisi adalah benar dan siap mengikuti prosedur pemeriksaan.
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i>Daftar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Info Jadwal -->
                <div class="card border-0 shadow-lg mb-4" data-aos="fade-left">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Pemeriksaan</h5>
                    </div>
                    <div class="card-body">
                        @forelse($jadwalPerPoli as $poliData)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">{{ $poliData['poli'] }}</h6>
                            @foreach($poliData['jadwal'] as $jadwal)
                            <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                                <div class="flex-shrink-0">
                                    <div class="bg-light rounded-circle p-2" style="width: 35px; height: 35px;">
                                        <i class="fas fa-calendar-day text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <small class="d-block">
                                        <strong>{{ $jadwal['hari'] }}</strong>: {{ $jadwal['jam'] }}
                                    </small>
                                    <small class="text-muted">
                                        <i class="fas fa-user-md me-1"></i>{{ $jadwal['dokter'] }}
                                        <span class="badge bg-secondary ms-2">Kuota: {{ $jadwal['kuota'] }}</span>
                                        @if(isset($jadwal['sisa_kuota_hari_ini']))
                                            <span class="badge {{ $jadwal['sisa_kuota_hari_ini'] > 0 ? 'bg-success' : 'bg-danger' }} ms-1">
                                                Sisa hari ini: {{ $jadwal['sisa_kuota_hari_ini'] }}
                                            </span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">Belum ada jadwal</p>
                        @endforelse
                    </div>
                </div>

                <!-- Cek Status -->
                <div class="card border-0 shadow-lg" data-aos="fade-left" data-aos-delay="100">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Cek Status Pendaftaran</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pelayanan.cek-status') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Masukkan No. Rekam Medis</label>
                                <input type="text" name="no_rm" class="form-control" placeholder="Contoh: RM-202312-0001"
                                       pattern="RM-[0-9]{6}-[0-9]{4}" title="Format: RM-YYYYMM-0001" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-search me-2"></i>Cek Status
                            </button>
                        </form>
                        <hr>
                        <small class="text-muted d-block text-center">
                            No. Rekam Medis akan diberikan setelah pendaftaran
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-section {
        position: relative;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        color: white;
        min-height: 40vh;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        border-bottom: none;
    }

    .form-control, .form-select {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
    }

    #kuota-info {
        font-size: 0.9rem;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .kuota-tersedia {
        color: #198754;
        background: #d1e7dd;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 4px solid #198754;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .kuota-penuh {
        color: #dc3545;
        background: #f8d7da;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 4px solid #dc3545;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .kuota-info-warning {
        color: #856404;
        background: #fff3cd;
        padding: 12px 16px;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .badge-jadwal {
        background: #e7f1ff;
        color: #0d6efd;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        display: inline-block;
        margin-right: 6px;
        margin-bottom: 6px;
        border: 1px solid #cfe2ff;
        transition: all 0.2s ease;
    }

    .badge-jadwal:hover {
        background: #cfe2ff;
        transform: translateY(-2px);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }

    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: color 0.3s;
    }

    .breadcrumb-item a:hover {
        color: white;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 30vh;
        }

        .display-4 {
            font-size: 2rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .badge-jadwal {
            display: block;
            margin-right: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // ============================================
    // VARIABEL GLOBAL
    // ============================================
    const poliSelect = document.getElementById('poli_tujuan');
    const tanggalInput = document.getElementById('tanggal_periksa');
    const kuotaInfo = document.getElementById('kuota-info');
    const submitBtn = document.getElementById('submitBtn');
    const infoJadwalPoli = document.getElementById('info-jadwal-poli');
    const jadwalList = document.getElementById('jadwal-list');
    const infoHari = document.getElementById('info-hari');
    const namaHari = document.getElementById('nama-hari');

    // ============================================
    // VALIDASI FORM
    // ============================================
    document.getElementById('pelayananForm').addEventListener('submit', function(e) {
        const terms = document.getElementById('terms');
        if (!terms.checked) {
            e.preventDefault();
            alert('Anda harus menyetujui pernyataan untuk melanjutkan pendaftaran.');
        }
    });

    // Format NIK hanya angka
    const nikInput = document.querySelector('input[name="nik"]');
    if (nikInput) {
        nikInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
        });
    }

    // Format No HP
    const noHpInput = document.querySelector('input[name="no_hp"]');
    if (noHpInput) {
        noHpInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);
        });
    }

    // ============================================
    // FUNGSI TAMPILAN JADWAL
    // ============================================

    // Fungsi untuk menampilkan info jadwal poli
    function tampilkanJadwalPoli() {
        if (!poliSelect || poliSelect.selectedIndex <= 0) {
            infoJadwalPoli.style.display = 'none';
            return;
        }

        const selectedOption = poliSelect.options[poliSelect.selectedIndex];
        const detailJadwal = selectedOption.getAttribute('data-detail');

        if (detailJadwal) {
            try {
                const jadwal = JSON.parse(detailJadwal);
                let html = '';

                jadwal.forEach(item => {
                    html += `
                        <div class="badge-jadwal">
                            <i class="fas fa-calendar-day me-1"></i>${item.hari || 'Unknown'}: ${item.jam || '00:00 - 00:00'}
                            <br><small>${item.dokter || 'Dokter'} (Kuota: ${item.kuota || 0})</small>
                        </div>
                    `;
                });

                jadwalList.innerHTML = html;
                infoJadwalPoli.style.display = 'block';
            } catch (e) {
                console.error('Error parsing jadwal:', e);
                infoJadwalPoli.style.display = 'none';
            }
        } else {
            infoJadwalPoli.style.display = 'none';
        }
    }

    // Fungsi untuk menampilkan info hari
    function tampilkanInfoHari() {
        if (!tanggalInput || !tanggalInput.value) {
            if (infoHari) infoHari.style.display = 'none';
            return;
        }

        const tanggal = tanggalInput.value;
        const date = new Date(tanggal + 'T00:00:00');
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const dayName = days[date.getDay()];

        if (namaHari) namaHari.textContent = dayName;
        if (infoHari) infoHari.style.display = 'block';

        // Cek apakah hari ini sesuai dengan jadwal poli yang dipilih
        if (poliSelect && poliSelect.selectedIndex > 0) {
            const selectedOption = poliSelect.options[poliSelect.selectedIndex];
            const jadwalAttr = selectedOption.getAttribute('data-jadwal');

            if (jadwalAttr && !jadwalAttr.includes(dayName)) {
                kuotaInfo.innerHTML = `
                    <div class="kuota-info-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Poli ini tidak beroperasi pada hari ${dayName}.
                        <br><small>Jadwal tersedia: ${jadwalAttr}</small>
                    </div>
                `;
                if (submitBtn) submitBtn.disabled = true;
            } else {
                if (submitBtn) submitBtn.disabled = false;
            }
        }
    }

    // ============================================
    // FUNGSI CEK KUOTA
    // ============================================

    function cekKuota() {
        if (!poliSelect || !tanggalInput) return;

        const poli = poliSelect.value;
        const tanggal = tanggalInput.value;

        // Hapus info sebelumnya
        if (kuotaInfo) kuotaInfo.innerHTML = '';

        if (poli && tanggal) {
            // Tampilkan loading
            kuotaInfo.innerHTML = '<div class="text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Mengecek ketersediaan...</div>';

            // Hitung tanggal minimal dan maksimal
            const selectedDate = new Date(tanggal + 'T00:00:00');
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const maxDate = new Date();
            maxDate.setDate(maxDate.getDate() + 30);

            if (selectedDate < today) {
                kuotaInfo.innerHTML = '<div class="kuota-info-warning"><i class="fas fa-exclamation-triangle me-2"></i>Tanggal tidak boleh sebelum hari ini</div>';
                if (submitBtn) submitBtn.disabled = true;
                return;
            }

            if (selectedDate > maxDate) {
                kuotaInfo.innerHTML = '<div class="kuota-info-warning"><i class="fas fa-exclamation-triangle me-2"></i>Tanggal periksa maksimal H+30</div>';
                if (submitBtn) submitBtn.disabled = true;
                return;
            }

            // Panggil API
            fetch('{{ route("pelayanan.cek-kuota") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    poli: poli,
                    tanggal: tanggal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.available) {
                    kuotaInfo.innerHTML = `
                        <div class="kuota-tersedia">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Tersedia ${data.sisa_kuota} dari ${data.total_kuota} kuota</strong>
                            <br>
                            <small>${data.message || ''}</small>
                            ${data.hari_operasional ? `<br><small class="text-muted"><i class="fas fa-calendar me-1"></i>Hari operasional: ${data.hari_operasional}</small>` : ''}
                            ${data.jam_operasional ? `<br><small class="text-muted"><i class="fas fa-clock me-1"></i>Jam: ${data.jam_operasional}</small>` : ''}
                            ${data.dokter ? `<br><small class="text-muted"><i class="fas fa-user-md me-1"></i>Dokter: ${data.dokter}</small>` : ''}
                        </div>
                    `;
                    if (submitBtn) submitBtn.disabled = false;
                } else {
                    let message = data.message || 'Tidak tersedia';
                    kuotaInfo.innerHTML = `
                        <div class="kuota-penuh">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>${message}</strong>
                            <br>
                            <small>Silakan pilih poli atau tanggal lain</small>
                            ${data.jadwal_tersedia ? `<br><small class="text-muted">Jadwal tersedia: ${data.jadwal_tersedia}</small>` : ''}
                        </div>
                    `;
                    if (submitBtn) submitBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                kuotaInfo.innerHTML = '<div class="kuota-info-warning"><i class="fas fa-exclamation-triangle me-2"></i>Gagal mengecek kuota. Silakan coba lagi.</div>';
                if (submitBtn) submitBtn.disabled = false;
            });
        } else {
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    // ============================================
    // EVENT LISTENER
    // ============================================

    if (poliSelect) {
        poliSelect.addEventListener('change', function() {
            tampilkanJadwalPoli();
            cekKuota();
            tampilkanInfoHari();
        });

        // Tampilkan jadwal jika sudah ada nilai
        if (poliSelect.value) {
            tampilkanJadwalPoli();
        }
    }

    if (tanggalInput) {
        tanggalInput.addEventListener('change', function() {
            tampilkanInfoHari();
            cekKuota();
        });

        // Tampilkan info hari jika sudah ada nilai
        if (tanggalInput.value) {
            tampilkanInfoHari();
        }
    }

    // Cek kuota jika sudah ada nilai sebelumnya (setelah validasi error)
    if (poliSelect && poliSelect.value && tanggalInput && tanggalInput.value) {
        cekKuota();
    }

    // Validasi No RM format
    const noRmInput = document.querySelector('input[name="no_rm"]');
    if (noRmInput) {
        noRmInput.addEventListener('input', function(e) {
            let value = this.value.toUpperCase();
            // Hapus karakter selain angka dan huruf
            value = value.replace(/[^RM0-9-]/g, '');

            // Format: RM-YYYYMM-0001
            if (value.length > 0 && !value.startsWith('RM')) {
                value = 'RM-' + value;
            }

            // Batasi panjang
            if (value.length > 15) {
                value = value.slice(0, 15);
            }

            this.value = value;
        });
    }
</script>
@endpush
