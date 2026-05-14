@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section dengan Slider (selalu terlihat) -->
    <section id="home" class="hero-section">
        <!-- Swiper Slider -->
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url('{{ asset('images/slide_satu.jpeg') }}');"></div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url('{{ asset('images/slide_dua.jpeg') }}');"></div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="slide-bg" style="background-image: url('{{ asset('images/slide-tiga.jpeg') }}');"></div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Pagination Dots -->
            <div class="swiper-pagination"></div>
        </div>

        <!-- Hero Content -->
        <div class="container hero-content">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="display-3 fw-bold mb-4" data-aos="fade-down">
                        SELAMAT DATANG DI<br>PUSKESMAS KATOI
                    </h1>
                    <p class="lead mb-5" data-aos="fade-up" data-aos-delay="200">
                        Melayani dengan Sepenuh Hati untuk Kesehatan Masyarakat yang Lebih Baik
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="400">
                        <a href="{{ route('pelayanan.index') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-calendar-check me-2"></i>Daftar Pelayanan Online
                        </a>
                        <a href="#profil" class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Container untuk konten yang bisa di-toggle -->
    <div id="dynamic-content">
        <!-- Profil Section -->
        <section id="profil" class="content-section py-5" data-section="profil">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Profil Puskesmas</h2>
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="position-relative">
                            <img src="{{ $profil && $profil->foto_background ? Storage::url($profil->foto_background) : asset('images/profil.jpeg') }}"
                                 alt="Profil Puskesmas" class="img-fluid rounded-3 shadow">
                            <div class="position-absolute bottom-0 end-0 bg-primary text-white p-3 rounded-3 m-3">
                                <i class="fas fa-hospital fa-3x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <h3 class="mb-4">{{ $profil->nama_puskesmas ?? 'PUSKESMAS KATOI' }}</h3>
                        <p class="lead mb-4">{{ $profil->deskripsi ?? 'Deskripsi Puskesmas' }}</p>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Alamat</h6>
                                        <p class="mb-0">{{ $profil->alamat ?? 'Jl. Kesehatan No. 123' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-phone fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Telepon</h6>
                                        <p class="mb-0">{{ $profil->telepon ?? '(0405) 123456' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-envelope fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Email</h6>
                                        <p class="mb-0">{{ $profil->email ?? 'info@puskesmaskatoi.com' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <i class="fas fa-clock fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Jam Operasional</h6>
                                        <p class="mb-0">08:00 - 16:00 WITA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visi Misi Section -->
        <section id="visi-misi" class="content-section py-5 bg-light" data-section="visi-misi" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Visi & Misi</h2>
                <div class="row">
                    <div class="col-md-6 mb-4" data-aos="flip-left">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="card-body text-center p-5">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                                    <i class="fas fa-eye fa-4x text-primary"></i>
                                </div>
                                <h3 class="mb-4">Visi</h3>
                                <p class="lead">{{ $visiMisi->visi ?? 'Visi Puskesmas' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" data-aos="flip-right">
                        <div class="card h-100 border-0 shadow-lg">
                            <div class="card-body p-5">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-4">
                                    <i class="fas fa-bullseye fa-4x text-primary"></i>
                                </div>
                                <h3 class="mb-4 text-center">Misi</h3>
                                <p class="lead" style="white-space: pre-line">{{ $visiMisi->misi ?? 'Misi Puskesmas' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi Section -->
        <section id="struktur" class="content-section py-5" data-section="struktur" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Struktur Organisasi</h2>
                <div class="row">
                    @forelse($strukturs as $struktur)
                        <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card text-center border-0 shadow-sm hover-card">
                                <div class="card-body">
                                    <div class="position-relative mb-3">
                                        @if($struktur->foto)
                                            <img src="{{ Storage::url($struktur->foto) }}"
                                                 alt="{{ $struktur->nama }}"
                                                 class="rounded-circle img-fluid border border-3 border-primary p-1"
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto border border-3 border-primary p-1"
                                                 style="width: 150px; height: 150px;">
                                                <i class="fas fa-user fa-4x text-primary"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0 translate-middle">
                                            <span class="badge bg-primary rounded-circle p-2">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <h5 class="card-title">{{ $struktur->nama }}</h5>
                                    <p class="card-text text-primary">{{ $struktur->jabatan }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada data struktur organisasi</p>
                        </div>
                    @endforelse
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('struktur.organisasi') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-sitemap me-2"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </section>

        <!-- Jadwal Pemeriksaan Section -->
        <section id="jadwal-pemeriksaan" class="content-section py-5 bg-light" data-section="jadwal-pemeriksaan" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Jadwal Pemeriksaan Pasien</h2>
                <div class="row">
                    @forelse($jadwalPemeriksaans as $jadwal)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white py-3">
                                    <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>{{ $jadwal->poli }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="fas fa-user-md text-primary me-2"></i>
                                        <span>{{ $jadwal->dokter }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span>{{ $jadwal->hari }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        <span>{{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <i class="fas fa-users text-primary me-2"></i>
                                        <span>Kuota: {{ $jadwal->kuota }} pasien</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $terisi = isset($jadwal->terisi) ? $jadwal->terisi : rand(0, $jadwal->kuota);
                                            $persentase = ($terisi / $jadwal->kuota) * 100;
                                        @endphp
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="width: {{ $persentase }}%;"
                                             aria-valuenow="{{ $persentase }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"></div>
                                    </div>
                                    <small class="text-muted">{{ $jadwal->kuota - $terisi }} slot tersedia</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada jadwal pemeriksaan</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Jadwal Posyandu Section -->
        <section id="jadwal-posyandu" class="content-section py-5" data-section="jadwal-posyandu" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Jadwal Posyandu</h2>
                <div class="row">
                    @forelse($jadwalPosyandus as $posyandu)
                        <div class="col-md-6 mb-4" data-aos="fade-up">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                                            <i class="fas fa-calendar-check fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-1">{{ $posyandu->nama_posyandu }}</h5>
                                            <p class="text-muted mb-0">{{ $posyandu->lokasi }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="mb-2">
                                                <i class="fas fa-calendar text-primary me-2"></i>
                                                {{ \Carbon\Carbon::parse($posyandu->tanggal)->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="mb-2">
                                                <i class="fas fa-clock text-primary me-2"></i>
                                                {{ substr($posyandu->jam_mulai, 0, 5) }} - {{ substr($posyandu->jam_selesai, 0, 5) }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($posyandu->keterangan)
                                        <div class="alert alert-info py-2 mt-2 mb-0">
                                            <i class="fas fa-info-circle me-2"></i>
                                            {{ $posyandu->keterangan }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada jadwal posyandu</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Sejarah Section -->
        <section id="sejarah" class="content-section py-5 bg-light" data-section="sejarah" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Sejarah Puskesmas Katoi</h2>
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card border-0 shadow-lg" data-aos="fade-up">
                            <div class="card-body p-5">
                                @if($sejarah)
                                    <p class="lead">{{ $sejarah->konten }}</p>
                                @else
                                    <p class="text-center text-muted">Belum ada data sejarah</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Berita Section -->
        <section id="berita" class="content-section py-5" data-section="berita" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Berita Terbaru</h2>
                <div class="row">
                    @forelse($beritas as $berita)
                        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($berita->gambar)
                                    <img src="{{ Storage::url($berita->gambar) }}"
                                         class="card-img-top"
                                         alt="{{ $berita->judul }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-primary d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="fas fa-newspaper fa-4x"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-calendar-alt text-primary me-2"></i>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</small>
                                    </div>
                                    <h5 class="card-title">{{ $berita->judul }}</h5>
                                    <p class="card-text">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                                    <a href="{{ route('berita.detail', $berita->id) }}" class="btn btn-primary">
                                        Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada berita</p>
                        </div>
                    @endforelse
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('berita.all') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
                    </a>
                </div>
            </div>
        </section>

        <!-- Galeri Section -->
        <section id="galeri" class="content-section py-5 bg-light" data-section="galeri" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Galeri Kegiatan</h2>
                <div class="row">
                    @forelse($galeris as $galeri)
                        <div class="col-md-4 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                            <div class="card border-0 shadow-sm h-100">
                                @if($galeri->tipe == 'foto')
                                    <div class="galeri-image-wrapper">
                                        <img src="{{ Storage::url($galeri->file) }}"
                                             class="card-img-top"
                                             alt="{{ $galeri->judul }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="galeri-overlay">
                                            <button type="button" class="btn btn-light btn-lg rounded-circle"
                                                    data-bs-toggle="modal" data-bs-target="#modal{{ $galeri->id }}">
                                                <i class="fas fa-search-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="position-relative">
                                        <img src="{{ $galeri->thumbnail ? Storage::url($galeri->thumbnail) : asset('images/video-thumb.jpg') }}"
                                             class="card-img-top"
                                             alt="{{ $galeri->judul }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <a href="{{ $galeri->file }}" target="_blank" class="btn btn-danger btn-lg rounded-circle">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                            <i class="fas fa-video me-1"></i>Video
                                        </span>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ $galeri->judul }}</h6>
                                    @if($galeri->deskripsi)
                                        <p class="card-text small text-muted">{{ Str::limit($galeri->deskripsi, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk Foto -->
                        @if($galeri->tipe == 'foto')
                        <div class="modal fade" id="modal{{ $galeri->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title">{{ $galeri->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center p-0">
                                        <img src="{{ Storage::url($galeri->file) }}" class="img-fluid" alt="{{ $galeri->judul }}">
                                    </div>
                                    @if($galeri->deskripsi)
                                    <div class="modal-footer border-0">
                                        <p class="text-muted mb-0">{{ $galeri->deskripsi }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada galeri</p>
                        </div>
                    @endforelse
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('galeri.all') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-images me-2"></i>Lihat Semua Galeri
                    </a>
                </div>
            </div>
        </section>

        <!-- Kontak Section -->
        <section id="kontak" class="content-section py-5" data-section="kontak" style="display: none;">
            <div class="container">
                <h2 class="section-title" data-aos="fade-up">Kontak Kami</h2>
                <div class="row">
                    <div class="col-lg-6 mb-4" data-aos="fade-right">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <h4 class="mb-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat</h4>
                                <p class="mb-4">{{ $profil->alamat ?? 'Jl. Kesehatan No. 123, Kec. Katoi, Kab. Kolaka Utara' }}</p>

                                <h4 class="mb-4"><i class="fas fa-phone text-primary me-2"></i>Telepon</h4>
                                <p class="mb-4">{{ $profil->telepon ?? '(0405) 123456' }}</p>

                                <h4 class="mb-4"><i class="fas fa-envelope text-primary me-2"></i>Email</h4>
                                <p class="mb-4">{{ $profil->email ?? 'info@puskesmaskatoi.com' }}</p>

                                <h4 class="mb-4"><i class="fas fa-clock text-primary me-2"></i>Jam Operasional</h4>
                                <p>Senin - Jumat: 08:00 - 16:00 WITA</p>
                                <p>Sabtu: 08:00 - 12:00 WITA</p>
                                <p class="text-danger">Minggu & Hari Libur: Tutup</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4" data-aos="fade-left">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <h4 class="mb-4"><i class="fas fa-map-marked-alt text-primary me-2"></i>Lokasi Kami</h4>
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127483.24871895866!2d120.9870848!3d-3.4951326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d8e3a5b5b5b5b5b%3A0x5b5b5b5b5b5b5b5b!2sKatoi%2C%20Kabupaten%20Kolaka%20Utara%2C%20Sulawesi%20Tenggara!5e0!3m2!1sid!2sid!4v1621234567890!5m2!1sid!2sid"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy">
                                    </iframe>
                                </div>
                                <p class="text-muted mt-3 small">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Klik map untuk melihat rute perjalanan ke Puskesmas Katoi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Kontak Cepat dengan AJAX -->
                <div class="row mt-4" data-aos="fade-up">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="mb-4 text-center">Kirim Pesan Cepat</h4>

                                <!-- Alert Container -->
                                <div id="kontakAlert" style="display: none;"></div>

                                <form id="quickContactForm" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="telepon" class="form-control" placeholder="No. Telepon">
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12">
                                            <textarea name="pesan" class="form-control" rows="3" placeholder="Pesan Anda..." required></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-primary px-5" id="btnKirimPesan">
                                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Tombol Kembali ke Beranda -->
    <div id="back-to-home" style="display: none; position: fixed; bottom: 100px; right: 30px; z-index: 9998;">
        <button class="btn btn-primary rounded-circle" style="width: 60px; height: 60px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);" onclick="showHome()">
            <i class="fas fa-home fa-2x"></i>
        </button>
    </div>

    <!-- Tombol WhatsApp Floating -->
    <a href="https://wa.me/62{{ preg_replace('/[^0-9]/', '', $profil->telepon ?? '81234567890') }}?text=Halo%20Puskesmas%20Katoi%2C%20saya%20ingin%20bertanya..."
       class="whatsapp-float"
       target="_blank"
       rel="noopener noreferrer"
       aria-label="Hubungi via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <style>
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #25d366;
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
        font-size: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
        animation: pulse-wa 2s infinite;
    }

    .whatsapp-float:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
        color: white;
    }

    @keyframes pulse-wa {
        0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
        100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
    }

    .content-section {
        transition: all 0.3s ease;
    }

    #back-to-home button {
        transition: all 0.3s ease;
    }

    #back-to-home button:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.5) !important;
    }

    @media (max-width: 768px) {
        .whatsapp-float {
            width: 50px;
            height: 50px;
            font-size: 25px;
            bottom: 20px;
            right: 20px;
        }

        #back-to-home {
            bottom: 80px;
            right: 20px;
        }

        #back-to-home button {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
    }
    </style>

@endsection

@push('styles')
<style>
    .hero-section {
        position: relative;
        min-height: 100vh;
        color: white;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .hero-swiper {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .swiper-slide {
        position: relative;
    }

    .swiper-slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 2;
    }

    .slide-bg {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }

    .hero-content {
        position: relative;
        z-index: 10;
        color: white;
        text-align: center;
        padding: 0 20px;
        width: 100%;
    }

    .hero-content h1 {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .hero-content p {
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    }

    .swiper-button-next,
    .swiper-button-prev {
        color: white;
        background: rgba(255,255,255,0.2);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        z-index: 20;
        transition: all 0.3s;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 20px;
    }

    .swiper-pagination-bullet {
        background: white;
        opacity: 0.7;
        width: 12px;
        height: 12px;
        z-index: 20;
    }

    .swiper-pagination-bullet-active {
        background: var(--primary-color);
        opacity: 1;
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .galeri-image-wrapper {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .galeri-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .galeri-image-wrapper:hover .galeri-overlay {
        opacity: 1;
    }

    .galeri-overlay .btn {
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .galeri-image-wrapper:hover .galeri-overlay .btn {
        transform: scale(1);
    }

    .progress {
        border-radius: 10px;
        margin-bottom: 5px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 10px;
    }

    .form-control {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.15);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }

    #kontakAlert {
        margin-bottom: 1rem;
        padding: 1rem;
        border-radius: 8px;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 80vh;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .hero-content .btn {
            display: block;
            margin: 10px auto;
            width: 100%;
            font-size: 1rem;
            padding: 10px 20px;
        }

        .swiper-button-next,
        .swiper-button-prev {
            display: none;
        }

        .section-title {
            font-size: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi: hanya profil yang terlihat, lainnya disembunyikan
    $('.content-section').hide();
    $('#profil').show();

    // Fungsi untuk menampilkan section tertentu
    window.showSection = function(sectionId) {
        // Sembunyikan semua section dengan animasi
        $('.content-section').fadeOut(300);

        // Tampilkan section yang dipilih
        $(`#${sectionId}`).fadeIn(500);

        // Tampilkan tombol back to home
        $('#back-to-home').fadeIn();

        // Update URL tanpa reload
        history.pushState(null, null, `#${sectionId}`);

        // Scroll ke hero section
        $('html, body').animate({ scrollTop: 0 }, 300);
    };

    // Fungsi untuk kembali ke beranda (menampilkan profil)
    window.showHome = function() {
        // Sembunyikan semua section
        $('.content-section').fadeOut(300);

        // Tampilkan profil
        $('#profil').delay(300).fadeIn(500);

        // Sembunyikan tombol back to home
        $('#back-to-home').fadeOut();

        // Update URL
        history.pushState(null, null, '#home');

        // Scroll ke hero section
        $('html, body').animate({ scrollTop: 0 }, 500);
    };

    // Handle klik pada nav link
    $(document).on('click', '.nav-link', function(e) {
        const href = $(this).attr('href');

        if (href && href.startsWith('#')) {
            e.preventDefault();

            const targetId = href.substring(1); // hapus karakter #

            // Jika target adalah home, tampilkan home
            if (targetId === 'home') {
                showHome();
            } else {
                // Cek apakah section dengan id tersebut ada
                if ($(`#${targetId}`).length) {
                    showSection(targetId);
                }
            }
        }
    });

    // Handle back/forward browser
    window.onpopstate = function(event) {
        const hash = window.location.hash.substring(1);
        if (hash && hash !== 'home' && $(`#${hash}`).length) {
            showSection(hash);
        } else {
            showHome();
        }
    };

    // Cek hash saat load
    const hash = window.location.hash.substring(1);
    if (hash && hash !== 'home' && $(`#${hash}`).length) {
        showSection(hash);
    }

    // Form kontak AJAX (tetap sama)
    $('#quickContactForm').on('submit', function(e) {
        e.preventDefault();

        // Reset form state
        $('#quickContactForm').find('.is-invalid').removeClass('is-invalid');
        $('#kontakAlert').hide().removeClass('alert-success alert-danger').empty();

        // Disable button
        const $btn = $('#btnKirimPesan');
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...').prop('disabled', true);

        // Kirim AJAX
        $.ajax({
            url: '{{ route("kontak.send") }}',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#kontakAlert')
                    .removeClass('alert-danger')
                    .addClass('alert alert-success')
                    .html('<i class="fas fa-check-circle me-2"></i>' + response.message)
                    .fadeIn();

                $('#quickContactForm')[0].reset();

                $('html, body').animate({
                    scrollTop: $('#kontakAlert').offset().top - 100
                }, 500);
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    errorMessage = '<ul class="mb-0">';
                    $.each(errors, function(key, value) {
                        errorMessage += '<li>' + value[0] + '</li>';
                        $(`[name="${key}"]`).addClass('is-invalid');
                    });
                    errorMessage += '</ul>';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                $('#kontakAlert')
                    .removeClass('alert-success')
                    .addClass('alert alert-danger')
                    .html('<i class="fas fa-exclamation-triangle me-2"></i>' + errorMessage)
                    .fadeIn();
            },
            complete: function() {
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Hilangkan error highlight saat mengetik
    $('#quickContactForm input, #quickContactForm textarea').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush
