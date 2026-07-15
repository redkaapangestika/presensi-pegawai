@extends('layouts.presensi')
@section('content')
    <style>
        /* Styling Custom Modern Dashboard */
        .bg-main-curve {
            background: linear-gradient(135deg, #1A56DB 0%, #3B82F6 100%);
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            padding: 30px 20px 70px 20px;
            position: relative;
            margin-bottom: -50px;
        }

        .profile-info {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .profile-info .avatar img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
        }

        .profile-text {
            margin-left: 15px;
            color: white;
            flex: 1;
        }

        .profile-text h3 {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 2px;
            line-height: 1.2;
        }

        .role-badge {
            background: #FDE68A;
            color: #B45309;
            font-weight: 600;
            padding: 3px 15px;
            border-radius: 12px;
            font-size: 0.75rem;
            display: inline-block;
            margin-top: 5px;
        }

        .menu-floating-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 20px 15px;
            margin: 0 15px;
            position: relative;
            z-index: 10;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 15px;
        }

        .modern-menu-item {
            width: 40%;
            text-align: center;
            background: #f8f9fa;
            padding: 15px 10px;
            border-radius: 15px;
            text-decoration: none;
            color: #4b5563;
            display: block;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .modern-menu-item:hover {
            background: #f3f4f6;
            text-decoration: none;
            color: #4b5563;
        }

        .modern-menu-icon {
            font-size: 32px;
            margin-bottom: 5px;
        }

        .modern-menu-text {
            font-size: 0.8rem;
            font-weight: 500;
            margin: 0;
        }

        .box-presensi-container {
            display: flex;
            gap: 15px;
            padding: 0 15px;
            margin-top: 30px;
        }

        .box-presensi {
            flex: 1;
            border-radius: 15px;
            padding: 20px 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .box-masuk {
            background-color: #ECFDF5;
            border: 1px solid #D1FAE5;
        }

        .box-pulang {
            background-color: #FEF2F2;
            border: 1px solid #FEE2E2;
        }

        .box-presensi .icon {
            font-size: 24px;
            margin-right: 10px;
        }

        .box-masuk .icon {
            color: #10B981;
        }

        .box-pulang .icon {
            color: #EF4444;
        }

        .box-presensi .details h4 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 700;
            color: #374151;
        }

        .box-presensi .details span {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .box-masuk .details span {
            color: #059669;
        }

        .box-pulang .details span {
            color: #DC2626;
        }

        .rekap-title {
            text-align: center;
            font-size: 1rem;
            font-weight: 700;
            margin: 25px 0 15px 0;
            color: #1f2937;
        }

        .rekap-grid {
            display: flex;
            padding: 0 15px;
            gap: 10px;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .rekap-item {
            background: white;
            border-radius: 12px;
            flex: 1;
            text-align: center;
            padding: 15px 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .rekap-item .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            padding: 0;
        }

        .rekap-icon {
            font-size: 24px;
            margin: 0 auto 5px auto;
            display: block;
        }

        .rekap-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: #4b5563;
        }

        .nav-tabs-modern {
            display: flex;
            margin: 25px 15px 15px 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .nav-tabs-modern .nav-item {
            flex: 1;
            text-align: center;
            border: none;
        }

        .nav-tabs-modern .nav-link {
            border: none;
            color: #6b7280;
            font-weight: 600;
            padding: 12px 10px;
            font-size: 0.85rem;
        }

        .nav-tabs-modern .nav-link.active {
            color: #1f2937;
            border-bottom: 2px solid #3B82F6;
            background: transparent;
        }

        .listview {
            margin: 0 15px;
            background: transparent;
        }

        .listview.image-listview>li {
            background: white;
            border-radius: 15px;
            margin-bottom: 10px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .listview.image-listview>li .item {
            padding: 12px 15px;
        }
    </style>

    <!-- Hero Section Biru -->
    <div class="bg-main-curve">
        <div class="profile-info">
            <div class="avatar">
                @if(!empty(Auth::guard('pegawai')->user()->foto))
                    <img src="{{ asset('storage/uploads/pegawai/' . Auth::guard('pegawai')->user()->foto) }}" alt="avatar">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar">
                @endif
            </div>
            <div class="profile-text">
                <h3>{{ Auth::guard('pegawai')->user()->nama_lengkap }}</h3>
                <span class="role-badge">{{ Auth::guard('pegawai')->user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <!-- Menu Grid Floating -->
    <div class="menu-floating-card">
        <a href="/editprofile" class="modern-menu-item">
            <div class="modern-menu-icon text-success">
                <ion-icon name="person"></ion-icon>
            </div>
            <h4 class="modern-menu-text">Profil</h4>
        </a>
        <a href="/presensi/izin" class="modern-menu-item">
            <div class="modern-menu-icon text-danger">
                <ion-icon name="calendar"></ion-icon>
            </div>
            <h4 class="modern-menu-text">Cuti</h4>
        </a>
        <a href="/presensi/histori" class="modern-menu-item">
            <div class="modern-menu-icon text-warning">
                <ion-icon name="document-text"></ion-icon>
            </div>
            <h4 class="modern-menu-text">Histori</h4>
        </a>
        <a href="/presensi/lokasi" class="modern-menu-item">
            <div class="modern-menu-icon text-primary">
                <ion-icon name="location"></ion-icon>
            </div>
            <h4 class="modern-menu-text">Lokasi</h4>
        </a>
    </div>

    <style>
        .presensi-photo {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #e5e7eb;
        }
    </style>
    <!-- Tombol Masuk & Pulang Terpisah -->
    <div class="box-presensi-container">
        <div class="box-presensi box-masuk">
            <div class="icon">
                @if($presensihariini !== null && $presensihariini->foto_in !== null)
                    <img src="{{ url('storage/uploads/absensi/' . $presensihariini->foto_in) }}" class="presensi-photo"
                        alt="Foto Masuk">
                @else
                    <ion-icon name="camera"></ion-icon>
                @endif
            </div>
            <div class="details">
                <h4>Masuk Presensi</h4>
                <span>{{ $presensihariini !== null ? $presensihariini->jam_in : '--:--' }}</span>
            </div>
        </div>

        <div class="box-presensi box-pulang">
            <div class="icon">
                @if($presensihariini !== null && $presensihariini->foto_out !== null)
                    <img src="{{ url('storage/uploads/absensi/' . $presensihariini->foto_out) }}" class="presensi-photo"
                        alt="Foto Pulang">
                @else
                    <ion-icon name="camera"></ion-icon>
                @endif
            </div>
            <div class="details">
                <h4>Pulang Presensi</h4>
                <span>{{ $presensihariini !== null && $presensihariini->jam_out !== null ? $presensihariini->jam_out : '--:--' }}</span>
            </div>
        </div>
    </div>

    <!-- Rekap Presensi Bulan Ini -->
    <h3 class="rekap-title">Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h3>

    <div class="rekap-grid">
        <div class="rekap-item" style="flex: 1 1 22%;">
            <span class="badge bg-danger">{{ $rekappresensi->jmlhadir ?? 0 }}</span>
            <ion-icon name="accessibility" class="rekap-icon text-primary"></ion-icon>
            <div class="rekap-label">Hadir</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 22%;">
            <span class="badge bg-danger">{{ $rekappresensi->jmlterlambat ?? 0 }}</span>
            <ion-icon name="alarm" class="rekap-icon text-danger"></ion-icon>
            <div class="rekap-label">Telat</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 22%;">
            <span class="badge bg-danger">{{ $rekapizin->jmlsakit ?? 0 }}</span>
            <ion-icon name="medkit" class="rekap-icon text-warning"></ion-icon>
            <div class="rekap-label">Sakit</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 22%;">
            <span class="badge bg-danger">{{ $rekapizin->jmlizin ?? 0 }}</span>
            <ion-icon name="document-text" class="rekap-icon text-success"></ion-icon>
            <div class="rekap-label">Izin</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 30%;">
            <span class="badge bg-danger">{{ $rekapizin->jmlcutitahunan ?? 0 }}</span>
            <ion-icon name="calendar" class="rekap-icon text-info"></ion-icon>
            <div class="rekap-label">Cuti<br>Tahunan</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 30%;">
            <span class="badge bg-danger">{{ $rekapizin->jmlcutimelahirkan ?? 0 }}</span>
            <ion-icon name="happy" class="rekap-icon text-pink"></ion-icon>
            <div class="rekap-label">Cuti<br>Melahirkan</div>
        </div>
        <div class="rekap-item" style="flex: 1 1 30%;">
            <span class="badge bg-danger">{{ $rekapizin->jmlcutilainnya ?? 0 }}</span>
            <ion-icon name="folder" class="rekap-icon text-secondary"></ion-icon>
            <div class="rekap-label">Cuti<br>Lainnya</div>
        </div>
    </div>


    <!-- Tabs Bulan Ini & Leaderboard -->
    <div class="presencetab mt-2">
        <ul class="nav nav-tabs-modern" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Bulan Ini</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Leaderboard</a>
            </li>
        </ul>

        <div class="tab-content" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach($historibulanini as $d)
                        <li>
                            <div class="item">
                                <div class="icon-box bg-primary rounded-circle text-white p-2"
                                    style="font-size:24px; margin-right:15px;">
                                    <ion-icon name="finger-print"></ion-icon>
                                </div>
                                <div class="in flex-column align-items-start">
                                    <div class="font-weight-bold" style="font-size:0.9rem; color:#374151;">
                                        {{ date("d M Y", strtotime($d->tgl_presensi)) }}
                                    </div>
                                    <div class="mt-1">
                                        <span class="badge badge-success px-2 py-1 mr-1">In: {{ $d->jam_in }}</span>
                                        <span class="badge badge-danger px-2 py-1">Out:
                                            {{ $d->jam_out !== null ? $d->jam_out : '--:--' }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $d)
                        <li>
                            <div class="item">
                                @if(!empty($d->foto))
                                    <img src="{{ url('storage/uploads/pegawai/' . $d->foto) }}" alt="image"
                                        class="image rounded-circle" style="width: 48px; border:2px solid #e5e7eb;">
                                @else
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image rounded-circle"
                                        style="width: 48px; border:2px solid #e5e7eb;">
                                @endif
                                <div class="in pl-3">
                                    <div>
                                        <b style="font-size:0.9rem; color:#374151;">{{ $d->nama_lengkap }}</b><br>
                                        <small class="text-muted">{{ $d->jabatan }}</small>
                                    </div>
                                    <span
                                        class="badge {{ $d->jam_in <= '08:00:00' ? 'badge-success' : 'badge-danger' }} px-2 py-1">{{ $d->jam_in }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection