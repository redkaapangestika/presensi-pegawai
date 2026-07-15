@extends('layouts.admin.tabler')
@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            transition: background 0.3s;
        }

        .card-success::before {
            background: linear-gradient(90deg, #20c997, #12a67a);
        }

        .card-info::before {
            background: linear-gradient(90deg, #4299e1, #3182ce);
        }

        .card-warning::before {
            background: linear-gradient(90deg, #f6ad55, #dd6b20);
        }

        .card-danger::before {
            background: linear-gradient(90deg, #f56565, #e53e3e);
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .dashboard-icon {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            color: #fff;
        }

        .icon-success {
            background: linear-gradient(135deg, #20c997 0%, #12a67a 100%);
        }

        .icon-info {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        }

        .icon-warning {
            background: linear-gradient(135deg, #f6ad55 0%, #dd6b20 100%);
        }

        .icon-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #1a202c;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
        }
    </style>

    <div class="page-header d-print-none mb-4 mt-3">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-primary fw-bold mb-1">Sekilas Info</div>
                    <h2 class="page-title text-dark">Dashboard Eksekutif</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                @if(Auth::guard('user')->user()->role == 'petugas')
                    <div class="col-12 mb-2">
                        <h3 class="fw-bold mb-1">Capaian Operasional Hari Ini</h3>
                        <div class="text-muted small">Angka ringkasan kehadiran harian.</div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #3b82f6 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kehadiran
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekappresensi->jmlhadir}}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Pegawai Hadir</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #10b981 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Izin</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlizin != null ? $rekapizin->jmlizin : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Status Izin Aktif</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #0ea5e9 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti Tahunan
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutitahunan != null ? $rekapizin->jmlcutitahunan : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #f43f5e !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti
                                    Melahirkan</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutimelahirkan != null ? $rekapizin->jmlcutimelahirkan : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #64748b !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti Lainnya
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutilainnya != null ? $rekapizin->jmlcutilainnya : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #f59e0b !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Sakit</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlsakit != null ? $rekapizin->jmlsakit : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Pegawai Sedang Sakit</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #eb7e7e !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Terlambat
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekappresensi->jmlterlambat }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Anomali Presensi</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::guard('user')->user()->role == 'lurah')
                    <div class="col-12 mb-2">
                        <h3 class="fw-bold mb-1">Executive Summary</h3>
                        <div class="text-muted small">Pemantauan eksekutif khusus Lurah. Angka ringkasan presensi harian dan
                            status penempatan staf.</div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #3b82f6 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Kehadiran
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekappresensi->jmlhadir}}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Hadir di Kantor</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #8b5cf6 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Dinas Luar
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $jmldinasluar }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Dinas Luar</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #10b981 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Izin</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlizin != null ? $rekapizin->jmlizin : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Pegawai Izin</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #0ea5e9 !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti Tahunan
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutitahunan != null ? $rekapizin->jmlcutitahunan : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #f43f5e !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti
                                    Melahirkan</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutimelahirkan != null ? $rekapizin->jmlcutimelahirkan : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #64748b !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Cuti Lainnya
                                </div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlcutilainnya != null ? $rekapizin->jmlcutilainnya : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Sedang Berlaku</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3 mt-3">
                        <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #f59e0b !important;">
                            <div class="card-body p-4 text-center text-md-start">
                                <div class="text-muted fw-bold"
                                    style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Sakit</div>
                                <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">
                                    {{ $rekapizin->jmlsakit != null ? $rekapizin->jmlsakit : 0 }}</h2>
                                <div class="text-muted" style="font-size: 0.75rem;">Pegawai Sakit</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::guard('user')->user()->role == 'admin')
                    <div class="col-12 mb-2">
                        <h3 class="fw-bold mb-1">Ringkasan Data Master</h3>
                        <div class="text-muted small">Anda mengelola konfigurasi utama dan pengguna aplikasi.</div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <a href="/pegawai" class="text-decoration-none">
                            <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #3b82f6 !important;">
                                <div class="card-body p-4 text-center text-md-start">
                                    <div class="text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Total Pegawai</div>
                                    <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">{{ $jmlpegawai }}</h2>
                                    <div class="text-muted" style="font-size: 0.75rem;">Pamong & Staf</div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <a href="/departemen" class="text-decoration-none">
                            <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #f59e0b !important;">
                                <div class="card-body p-4 text-center text-md-start">
                                    <div class="text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">Role Sistem</div>
                                    <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">{{ $jmldepartemen }}</h2>
                                    <div class="text-muted" style="font-size: 0.75rem;">Berbagai Departemen</div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-12 col-lg-4">
                        <a href="/users" class="text-decoration-none">
                            <div class="card dashboard-card shadow-sm border-0" style="border-top: 4px solid #8b5cf6 !important;">
                                <div class="card-body p-4 text-center text-md-start">
                                    <div class="text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px; text-transform: uppercase;">User Aktif</div>
                                    <h2 class="m-0 fw-bold mt-2 mb-1" style="font-size: 2.5rem; color: #1e293b; line-height: 1;">{{ $jmlpengelola }}</h2>
                                    <div class="text-muted" style="font-size: 0.75rem;">Pengelola Sistem</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection