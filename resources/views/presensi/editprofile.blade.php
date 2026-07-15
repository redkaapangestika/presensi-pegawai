@extends('layouts.presensi')

@section('content')
    <style>
        /* Styling Custom Modern Profile */
        .bg-profile-curve {
            background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%);
            padding: 50px 20px 40px 20px;
            text-align: center;
            position: relative;
        }

        .bg-profile-curve .avatar {
            display: inline-block;
            margin-bottom: 15px;
        }

        .bg-profile-curve .avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .bg-profile-curve h3 {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .role-badge {
            background: #FDE68A;
            color: #B45309;
            font-weight: 600;
            padding: 4px 20px;
            border-radius: 12px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .profile-info-card {
            background: white;
            margin: -20px 15px 15px 15px;
            border-radius: 15px;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 10;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 10px;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .info-value {
            color: #1f2937;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .action-cards {
            padding: 10px 15px;
            margin-bottom: 100px;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            cursor: pointer;
        }

        .action-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 15px;
        }

        .action-icon.bg-blue {
            background: #e0f2fe;
            color: #0284c7;
        }

        .action-icon.bg-yellow {
            background: #fef3c7;
            color: #d97706;
        }

        .action-text {
            flex: 1;
        }

        .action-text h4 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1f2937;
        }

        .action-text p {
            margin: 0;
            font-size: 0.75rem;
            color: #6b7280;
        }
    </style>

    <div class="row" style="position: absolute; top: 10px; left: 0; width: 100%; z-index: 99;">
        <div class="col">
            @if(Session::get('success'))
                <div class="alert alert-success mx-2 mt-2">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::get('error'))
                <div class="alert alert-danger mx-2 mt-2">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Header Biru -->
    <div class="bg-profile-curve">
        <div class="avatar">
            @if(!empty($data->foto))
                <img src="{{ asset('storage/uploads/pegawai/' . $data->foto) }}" alt="avatar">
            @else
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar">
            @endif
        </div>
        <h3>{{ $data->nama_lengkap }}</h3>
        <span class="role-badge">Pegawai</span>
    </div>

    <!-- Kartu Informasi Detail -->
    <div class="profile-info-card">
        <div class="info-item">
            <span class="info-label">ID Pegawai</span>
            <span class="info-value">{{ $data->id_pegawai }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">No HP</span>
            <span class="info-value">{{ $data->no_hp ?? '-' }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Role Sistem</span>
            <span class="info-value">{{ $data->jabatan }}</span>
        </div>
        <div class="info-item">
            <span class="info-label">Kuota Cuti</span>
            <span class="info-value">8 hari tersisa</span>
        </div>
    </div>

    <!-- Aksi Accordion Edit -->
    <div class="action-cards">
        <!-- Edit Profil Header -->
        <div class="action-card" data-toggle="collapse" href="#collapseEditProfil" role="button" aria-expanded="false"
            aria-controls="collapseEditProfil">
            <div style="display:flex; align-items:center; flex:1">
                <div class="action-icon bg-blue">
                    <ion-icon name="person"></ion-icon>
                </div>
                <div class="action-text">
                    <h4>Edit Profil</h4>
                    <p>Ubah foto dan kontak</p>
                </div>
            </div>
            <ion-icon name="chevron-forward-outline" style="font-size: 20px; color: #9ca3af;"></ion-icon>
        </div>

        <!-- Edit Profil Form Area -->
        <div class="collapse" id="collapseEditProfil" style="margin-top: -10px; margin-bottom: 20px;">
            <div class="card p-3 shadow-sm border-0" style="border-radius: 15px;">
                <form action="/presensi/updateprofile" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <label style="font-size:0.8rem; font-weight:600">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $data->nama_lengkap }}" name="nama_lengkap"
                            autocomplete="off" style="border-radius:10px;">
                    </div>
                    <div class="form-group mb-2">
                        <label style="font-size:0.8rem; font-weight:600">No. HP</label>
                        <input type="text" class="form-control" value="{{ $data->no_hp }}" name="no_hp" autocomplete="off"
                            style="border-radius:10px;">
                    </div>
                    <div class="form-group mb-3">
                        <label style="font-size:0.8rem; font-weight:600">Foto Profil (Kosongkan jika tidak diubah)</label>
                        <div class="custom-file-upload mt-0" id="fileUpload1" style="height: auto; padding: 10px;">
                            <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                            <label for="fileuploadInput" style="margin:0">
                                <span>
                                    <strong><ion-icon name="cloud-upload" style="font-size:24px"></ion-icon><br>Pilih Foto
                                        Baru</strong>
                                </span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="border-radius:10px;">Simpan
                        Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Keamanan Akun Header -->
        <div class="action-card" data-toggle="collapse" href="#collapseKeamanan" role="button" aria-expanded="false"
            aria-controls="collapseKeamanan">
            <div style="display:flex; align-items:center; flex:1">
                <div class="action-icon bg-yellow">
                    <ion-icon name="lock-closed"></ion-icon>
                </div>
                <div class="action-text">
                    <h4>Keamanan Akun</h4>
                    <p>Ubah password login</p>
                </div>
            </div>
            <ion-icon name="chevron-forward-outline" style="font-size: 20px; color: #9ca3af;"></ion-icon>
        </div>

        <!-- Keamanan Akun Form Area -->
        <div class="collapse" id="collapseKeamanan" style="margin-top: -10px; margin-bottom: 20px;">
            <div class="card p-3 shadow-sm border-0" style="border-radius: 15px;">
                <form action="/presensi/updateprofile" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Dibutuhkan untuk validasi form -->
                    <input type="hidden" name="nama_lengkap" value="{{ $data->nama_lengkap }}">
                    <input type="hidden" name="no_hp" value="{{ $data->no_hp }}">

                    <div class="form-group mb-3">
                        <label style="font-size:0.8rem; font-weight:600">Password Baru</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan password baru"
                            required autocomplete="off" style="border-radius:10px;">
                    </div>
                    <button type="submit" class="btn btn-warning btn-block text-white" style="border-radius:10px;">Update
                        Password</button>
                </form>
            </div>
        </div>

        <!-- Toggle Dark Mode -->
        <div class="action-card mt-3">
            <div style="display:flex; align-items:center; flex:1">
                <div class="action-icon" style="background:#1f2937; color:white;">
                    <ion-icon name="moon"></ion-icon>
                </div>
                <div class="action-text">
                    <h4>Tema Gelap</h4>
                    <p>Ubah tampilan menjadi mode gelap</p>
                </div>
            </div>
            <div class="custom-control custom-switch" style="padding-left: 2.25rem;">
                <input type="checkbox" class="custom-control-input" id="darkModeSwitch">
                <label class="custom-control-label" for="darkModeSwitch"></label>
            </div>
        </div>

        <!-- Logout Button -->
        <a href="/proseslogout" class="action-card mt-3" style="text-decoration:none; border: 1px solid #fee2e2;">
            <div style="display:flex; align-items:center; flex:1">
                <div class="action-icon" style="background:#fee2e2; color:#ef4444;">
                    <ion-icon name="log-out-outline"></ion-icon>
                </div>
                <div class="action-text text-danger">
                    <h4 style="color:#ef4444;">Keluar Sinkronisasi</h4>
                    <p style="color:#ef4444;">Akhiri sistem secara aman dari sesi ini</p>
                </div>
            </div>
            <ion-icon name="exit-outline" style="font-size: 20px; color: #ef4444;"></ion-icon>
        </a>

    </div>
@endsection