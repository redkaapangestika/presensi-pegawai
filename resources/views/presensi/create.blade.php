@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .appHeader.bg-primary {
            background: #0284c7 !important;
            border: none;
            box-shadow: none;
        }

        .presensi-container {
            padding: 70px 20px 120px 20px;
            background: #f9fafb;
            min-height: 100vh;
        }

        .webcam-capture,
        .webcam-capture video {
            display: inline;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            background-color: #000;
        }

        #map {
            height: 180px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 2px solid #e5e7eb;
            margin-bottom: 10px;
            z-index: 1;
        }

        .address-card {
            background-color: white;
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            font-size: 0.8rem;
            color: #374151;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .address-card ion-icon {
            font-size: 20px;
            color: #ef4444;
            margin-top: 2px;
        }

        .btn-absen {
            border-radius: 15px;
            padding: 15px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-in {
            background: #10b981;
            color: white;
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        }

        .btn-out {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        .log-kerja-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin-top: 15px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .log-kerja-card label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .log-kerja-input {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 0.9rem;
            width: 100%;
            color: #4b5563;
            transition: all 0.2s;
            resize: none;
        }

        .log-kerja-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
    <div class="presensi-container">
        <input type="hidden" id="lokasi">

        @if(isset($is_dinas_luar) && $is_dinas_luar == 1)
            <div class="alert alert-info mb-3 d-flex align-items-center"
                style="border-radius: 12px; font-size: 0.85rem; padding: 10px 15px; background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #1d4ed8;">
                <ion-icon name="information-circle-outline" style="font-size: 1.5rem; margin-right: 10px;"></ion-icon>
                <div>
                    <strong>Mode Dinas Luar Aktif</strong><br>
                    Presensi dapat dilakukan dari lokasi penugasan (batas radius diabaikan).
                </div>
            </div>
        @endif

        <div class="webcam-capture mb-3"></div>

        <div id="map"></div>
        <div class="address-card" id="address-container" style="display: none;">
            <ion-icon name="location"></ion-icon>
            <div id="address-text">Mencari alamat...</div>
        </div>

        @if ($cek > 0)
            <!-- Muncul Saat Pulang -->
            @if(isset($hasTask) && $hasTask)
                <div class="log-kerja-card">
                    <label class="fw-bold text-dark">Target Pekerjaan Dari Petugas</label>
                    <div
                        style="background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 12px; color: #334155; white-space: pre-wrap; font-size: 14px; border: 1px solid #cbd5e1;">
                        {{ $isiLogKerja }}</div>

                    <div class="mb-3 d-flex align-items-start" style="gap: 10px;">
                        <input type="checkbox" id="tugas_selesai" value="1"
                            style="width: 20px; height: 20px; flex-shrink: 0; margin: 0; position: static; cursor: pointer;">
                        <label class="text-dark fw-medium" for="tugas_selesai"
                            style="font-size: 13.5px; line-height: 1.4; cursor: pointer;">
                            Saya mengonfirmasi tugas di atas telah dikerjakan.
                        </label>
                    </div>

                    <label class="fw-bold text-dark">Catatan Tambahan (Opsional)</label>
                    <textarea id="log_kerja" rows="2" class="log-kerja-input mb-3"
                        placeholder="Tambahkan keterangan lain jika diperlukan..."></textarea>

                    <label>Berkas/File Bukti (Wajib)</label>
                    <input type="file" id="berkas_log" name="berkas_log" class="form-control"
                        style="background:#f9fafb; border: 1px solid #e5e7eb; border-radius:12px; padding:8px 15px;">
                    <small class="text-muted d-block mt-1">Format: PDF, JPG, PNG (Max: 2MB)</small>
                </div>
            @else
                <!-- Form Harian Biasa untuk Pegawai yang tidak ditambahkan target oleh Petugas -->
                <div class="log-kerja-card">
                    <label class="fw-bold text-dark">Log Kerja Harian (Wajib)</label>
                    <textarea id="log_kerja" rows="3" class="log-kerja-input mb-3"
                        placeholder="Tuliskan ringkasan kegiatan dan bukti pekerjaan Anda hari ini secara detail..."></textarea>

                    <label class="fw-bold text-dark">Berkas/File Bukti Kegiatan (Wajib)</label>
                    <input type="file" id="berkas_log" name="berkas_log" class="form-control"
                        style="background:#f9fafb; border: 1px solid #e5e7eb; border-radius:12px; padding:8px 15px;">
                    <small class="text-muted d-block mt-1">Format: PDF, JPG, PNG (Max: 2MB)</small>
                </div>
            @endif


            <button type="button" id="takeabsen" class="btn-absen btn-out">
                <ion-icon name="camera" style="font-size: 24px;"></ion-icon>
                Absen Pulang
            </button>
        @else
            <!-- Muncul Saat Berangkat -->
            <button type="button" id="takeabsen" class="btn-absen btn-in">
                <ion-icon name="camera" style="font-size: 24px;"></ion-icon>
                Absen Masuk
            </button>
        @endif

    </div>
@endsection

@push('myscript')
    <script>
        // Konfigurasi WebcamJS
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        // Menyematkan webcam
        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi')
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + ", " + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([-7.778497430337909, 110.40738509292642], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10
            }).addTo(map);

            // Tampilkan card address dan get reverse geocoding
            $('#address-container').show();
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        $('#address-text').html('<strong>Lokasi Anda:</strong><br>' + data.display_name);
                    } else {
                        $('#address-text').html('Pencarian alamat gagal.');
                    }
                })
                .catch(error => {
                    $('#address-text').text("Error menemukan alamat detail.");
                });
        }

        function errorCallback(error) {
            console.log("Error getting location: " + error.message);
        }

        $('#takeabsen').click(function (e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");

            // Validasi Log Kerja jika elemen ada (hanya saat Clock Out)
            if ($("#berkas_log").length) {
                if ($("#tugas_selesai").length > 0 && !$("#tugas_selesai").is(":checked")) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Silahkan centang kotak konfirmasi penyelesaian tugas Anda terlebih dahulu.',
                        icon: 'warning'
                    });
                    return false;
                }

                var log_kerja = $("#log_kerja").val() ? $("#log_kerja").val().trim() : "";
                var berkas_log = $('#berkas_log')[0].files[0];

                // Wajib diisi Jika textarea muncul tapi tugas_selesai tidak ada (Artinya mode normal)
                if ($("#tugas_selesai").length === 0 && log_kerja === "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Silahkan isikan ringkasan kegiatan pekerjaan Anda hari ini.',
                        icon: 'warning'
                    });
                    return false;
                }

                if (!berkas_log) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Silahkan upload berkas/file bukti kerja Anda terlebih dahulu.',
                        icon: 'warning'
                    });
                    return false;
                }

                formData.append('log_kerja', log_kerja);
                formData.append('berkas_log', berkas_log);
            }

            Webcam.snap(function (uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();

            formData.append('image', image);
            formData.append('lokasi', lokasi);

            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        Swal.fire({
                            title: 'Berhasil',
                            text: status[1],
                            icon: 'success'
                        })
                        setTimeout("location.href='/dashboard'", 3000);
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: status[1],
                            icon: 'error'
                        })
                    }
                }
            });

        });
    </script>
@endpush