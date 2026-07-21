@extends('layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Profil
                    </h2>
                    <div class="text-muted mt-1">Ubah foto profil dan kata sandi Anda</div>
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
                <div class="col-12 col-md-8 mx-auto">
                    <form action="/panel/profile" method="POST" enctype="multipart/form-data" class="card">
                        @csrf
                        <div class="card-body">
                            <h3 class="card-title">Profil Anda</h3>

                            <div class="mb-3 text-center">
                                @if(!empty($user->foto))
                                    <span class="avatar avatar-xl mb-3"
                                        style="background-image: url('{{ Storage::url('uploads/admin/' . $user->foto) }}')"></span>
                                @else
                                    <span class="avatar avatar-xl mb-3"
                                        style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random')"></span>
                                @endif

                                <div>
                                    <label class="form-label" for="foto">Unggah Foto Baru</label>
                                    <input type="file" name="foto" id="foto" class="form-control"
                                        accept=".png, .jpg, .jpeg">
                                    <small class="form-hint">Biarkan kosong jika tidak ingin mengubah foto</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ $user->name }}" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password baru">
                                <small class="form-hint">Biarkan kosong jika tidak ingin mengubah kata sandi</small>
                            </div>

                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection

@push('myscript')
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

            // Trigger map invalidateSize after a slight delay to ensure it renders correctly inside the layout
            setTimeout(function () {
                map.invalidateSize();
            }, 100);
        });
    </script>
@endpush