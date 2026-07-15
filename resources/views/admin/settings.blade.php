@extends('layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Sistem
                    </h2>
                    <div class="text-muted mt-1">Atur konfigurasi lokasi kantor dan aturan cuti</div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>{{ session('success') }}</div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <div>{{ session('warning') }}</div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="row row-cards">
                @if(Auth::guard('user')->user()->role == 'admin' || Auth::guard('user')->user()->role == 'petugas')
                    <div class="col-12 col-md-8 mx-auto">
                        <form action="/panel/settings/lokasi" method="POST" class="card">
                            @csrf
                            <div class="card-body">
                                <h3 class="card-title">Pengaturan Lokasi Kantor</h3>

                                @php
                                    $konfig = \Illuminate\Support\Facades\DB::table('konfigurasi_lokasi')->first();
                                @endphp

                                <div class="mb-3">
                                    <label class="form-label">Titik Koordinat (Latitude, Longitude)</label>
                                    <input type="text" name="titik_koordinat" id="titik_koordinat" class="form-control"
                                        value="{{ $konfig->titik_koordinat ?? '-7.7597148,110.3957252' }}" required>
                                    <small class="form-hint">Pilih lokasi pada peta atau set manual.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Cari Lokasi / Alamat</label>
                                    <div class="row gx-2">
                                        <div class="col">
                                            <input type="text" id="search-location" class="form-control" placeholder="Ketik nama lokasi lalu klik tombol di samping...">
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-primary btn-icon" id="btn-search-location" aria-label="Cari Lokasi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-outline-success" id="btn-current-location">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-current-location"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M12 3l0 2" /><path d="M12 19l0 2" /><path d="M3 12l2 0" /><path d="M19 12l2 0" /></svg>
                                                Lokasi Saya
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                                    <div id="map" style="height: 300px; width: 100%; border-radius: 8px; z-index: 1;"></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Radius Toleransi Presensi (Meter)</label>
                                    <input type="number" name="radius_meter" class="form-control"
                                        value="{{ $konfig->radius_meter ?? 100 }}" required>
                                    <small class="form-hint">Jarak maksimal absen disetujui (Default: 100)</small>
                                </div>

                                <h4 class="card-title mt-4">Pengaturan Cuti</h4>
                                <div class="mb-3">
                                    <label class="form-label">Kuota Cuti Tahunan (Hari)</label>
                                    <input type="number" name="kuota_cuti_tahunan" class="form-control"
                                        value="{{ $konfig->kuota_cuti_tahunan ?? 12 }}" required>
                                    <small class="form-hint">Jumlah default jatah cuti pegawai per tahun.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kuorum Cuti Harian (Pegawai)</label>
                                    <input type="number" name="kuorum_cuti_harian" class="form-control"
                                        value="{{ $konfig->kuorum_cuti_harian ?? 3 }}" required>
                                    <small class="form-hint">Batas maksimal pegawai yang boleh cuti di hari yang sama.</small>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-success">Update Pengaturan</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        $(document).ready(function () {
            var defaultLocation = "{{ isset($konfig) && $konfig->titik_koordinat ? $konfig->titik_koordinat : '-7.7597148,110.3957252' }}";
            var coords = defaultLocation.split(',');
            var lat = parseFloat(coords[0]);
            var lng = parseFloat(coords[1]);

            var map = L.map('map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([lat, lng], { draggable: true }).addTo(map);

            function updateInput(lat, lng) {
                $('#titik_koordinat').val(lat + ',' + lng);
            }

            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                updateInput(position.lat, position.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateInput(e.latlng.lat, e.latlng.lng);
            });

            $('#titik_koordinat').on('input', function () {
                var val = $(this).val();
                var parts = val.split(',');
                if (parts.length === 2) {
                    var newLat = parseFloat(parts[0]);
                    var newLng = parseFloat(parts[1]);
                    if (!isNaN(newLat) && !isNaN(newLng)) {
                        marker.setLatLng([newLat, newLng]);
                        map.setView([newLat, newLng]);
                    }
                }
            });

            $('#btn-search-location').click(function () {
                var query = $('#search-location').val();
                if (query != '') {
                    // Tampilkan loading di button
                    var btnHtml = $(this).html();
                    $(this).html('<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-loader" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="6" x2="12" y2="3"></line><line x1="16.25" y1="7.75" x2="18.4" y2="5.6"></line><line x1="18" y1="12" x2="21" y2="12"></line><line x1="16.25" y1="16.25" x2="18.4" y2="18.4"></line><line x1="12" y1="18" x2="12" y2="21"></line><line x1="7.75" y1="16.25" x2="5.6" y2="18.4"></line><line x1="6" y1="12" x2="3" y2="12"></line><line x1="7.75" y1="7.75" x2="5.6" y2="5.6"></line></svg>');
                    var btn = $(this);

                    $.ajax({
                        url: 'https://nominatim.openstreetmap.org/search',
                        data: {
                            format: 'json',
                            q: query
                        },
                        success: function (res) {
                            btn.html(btnHtml); // kembalikan svg search
                            if (res.length > 0) {
                                var resLat = parseFloat(res[0].lat);
                                var resLng = parseFloat(res[0].lon);
                                map.setView([resLat, resLng], 17);
                                marker.setLatLng([resLat, resLng]);
                                updateInput(resLat, resLng);
                                Swal.fire({
                                    title: 'Lokasi Ditemukan',
                                    text: res[0].display_name,
                                    icon: 'success'
                                });
                            } else {
                                Swal.fire('Ups!', 'Lokasi tidak ditemukan, coba kata kunci lain.', 'warning');
                            }
                        },
                        error: function () {
                            btn.html(btnHtml);
                            Swal.fire('Error', 'Gagal menghubungkan ke server peta.', 'error');
                        }
                    });
                } else {
                    Swal.fire('Perhatian', 'Ketik nama lokasi terlebih dahulu!', 'warning');
                }
            });

            $('#btn-current-location').click(function () {
                var btnHtml = $(this).html();
                $(this).html('Mencari...');
                var btn = $(this);
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        btn.html(btnHtml);
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        map.setView([lat, lng], 17);
                        marker.setLatLng([lat, lng]);
                        updateInput(lat, lng);
                        Swal.fire('Berhasil', 'Menemukan titik lokasi perangkat Anda saat ini.', 'success');
                    }, function (error) {
                        btn.html(btnHtml);
                        Swal.fire('Ups', 'Gagal mendapatkan akses lokasi. Pastikan izin lokasi (GPS) aktif.', 'error');
                    });
                } else {
                    btn.html(btnHtml);
                    Swal.fire('Ups', 'Browser tidak mendukung deteksi lokasi.', 'error');
                }
            });

            // Trigger map invalidateSize after a slight delay to ensure it renders correctly inside the layout
            setTimeout(function () {
                map.invalidateSize();
            }, 100);
        });
    </script>
@endpush