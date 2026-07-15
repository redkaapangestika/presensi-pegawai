@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Lokasi Saya</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .appHeader.bg-primary {
            background: #0284c7 !important;
            border: none;
            box-shadow: none;
        }

        .lokasi-container {
            padding: 70px 20px 120px 20px;
            background: #f9fafb;
            min-height: 100vh;
        }

        #map-lokasi {
            height: 350px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 2px solid #e5e7eb;
            margin-bottom: 20px;
            z-index: 1;
        }

        .address-card {
            background-color: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            font-size: 0.9rem;
            color: #374151;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .address-card ion-icon {
            font-size: 24px;
            color: #ef4444;
            margin-top: 2px;
        }

        .title-lokasi {
            font-weight: 700;
            font-size: 1.1rem;
            color: #1f2937;
            margin-bottom: 5px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
    <div class="lokasi-container">

        <div id="map-lokasi"></div>

        <div class="address-card" id="address-container">
            <ion-icon name="location"></ion-icon>
            <div>
                <div class="title-lokasi">Lokasi Anda Saat Ini</div>
                <div id="address-text">Mencari alamat...</div>
            </div>
        </div>

    </div>
@endsection

@push('myscript')
    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            $('#address-text').html('Geolocation tidak didukung di browser ini.');
        }

        function successCallback(position) {
            var map = L.map('map-lokasi').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            // Lokasi Kantor Kalurahan (Radius)
            var circle = L.circle([-7.778497430337909, 110.40738509292642], {
                color: 'blue',
                fillColor: '#0284c7',
                fillOpacity: 0.3,
                radius: 100 // 100 meter radius kantor
            }).addTo(map);

            marker.bindPopup("<b>Ini adalah lokasi Anda</b>").openPopup();
            circle.bindPopup("<b>Area Presensi Kantor</b>");

            // Reverse geocoding
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.display_name) {
                        $('#address-text').text(data.display_name);
                    } else {
                        $('#address-text').text('Alamat detail tidak ditemukan.');
                    }
                })
                .catch(error => {
                    $('#address-text').text("Error menemukan alamat detail.");
                });
        }

        function errorCallback(error) {
            $('#address-text').html('Error mendapatkan lokasi: ' + error.message);
        }
    </script>
@endpush