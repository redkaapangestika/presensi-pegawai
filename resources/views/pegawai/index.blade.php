@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <h2 class="page-title">Data Pegawai</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if(Session::get('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> {{ Session::get('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if (Session::get('warning'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Warning!</strong> {{ Session::get('warning') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btnTambahPegawai">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/pegawai" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_pegawai" id="kode_dept" class="form-control" placeholder="Cari Pegawai..." value="{{ Request('nama_pegawai') }}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-select">
                                                    <option value="">Pilih Departemen</option>
                                                    @foreach ($departemen as $d)
                                                    <option {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}" {{ request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>{{ $d->nama_dept }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id Pegawai</th>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Nomer HP</th>
                                            <th>Foto</th>
                                            <th>Departemen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pegawai as $d)
                                        @php
                                        $path = Storage::url('uploads/pegawai/' . $d->foto);
                                        @endphp
                                        <!-- Data pegawai akan ditampilkan di sini -->
                                        <tr>
                                            <td>{{ $loop->iteration +$pegawai->firstItem() - 1 }}</td>
                                            <td>{{ $d->id_pegawai }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jabatan }}</td>
                                            <td>{{ $d->no_hp }}</td>
                                            <td>
                                                @if (empty($d->foto))
                                                <img src="{{ asset('assets/img/nophoto.png') }}" class="avatar" alt="">
                                                @else
                                                <img src="{{ url($path) }}" class="avatar" alt="">
                                                @endif
                                            </td>
                                            <td>{{ $d->nama_dept }}</td>
                                            <td></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{ $pegawai->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
<div class="modal modal-blur fade" id="modal-inputpegawai" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/pegawai/store" method="POST" id="frmPegawai" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                        <path d="M5 11h1v2h-1l0 -2" />
                                        <path d="M10 11l0 2" />
                                        <path d="M14 11h1v2h-1l0 -2" />
                                        <path d="M19 11l0 2" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="id_pegawai" class="form-control" placeholder="ID Pegawai" name="id_pegawai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Nama Pegawai">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-screen">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M19.03 17.818a3 3 0 0 0 1.97 -2.818v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8c0 1.317 .85 2.436 2.03 2.84" />
                                        <path d="M10 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M8 21a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="jabatan" class="form-control" name="jabatan" placeholder="Jabatan">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-phone-plus">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                        <path d="M15 6h6m-3 -3v6" />
                                    </svg>
                                </span>
                                <input type="text" value="" id="no_hp" class="form-control" name="no_hp" placeholder="No HP">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <input type="file" class="form-control" name="foto">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <select name="kode_dept" id="kode_dept" class="form-select">
                                <option value="">Pilih Departemen</option>
                                @foreach ($departemen as $d)
                                <option {{ Request('kode_dept') == $d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}" {{ request('kode_dept') == $d->kode_dept ? 'selected' : '' }}>{{ $d->nama_dept }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 14l11 -11" />
                                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                    </svg>
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#btnTambahPegawai").click(function() {
            $("#modal-inputpegawai").modal("show");
        });

        $("#frmPegawai").submit(function(e) {
            var id_pegawai = $("#id_pegawai").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jabatan = $("#jabatan").val();
            var no_hp = $("#no_hp").val();
            var kode_dept = $("#frmPegawai").find("#kode_dept").val();
            if (id_pegawai == "") {
                //alert("ID Pegawai Wajib Diisi");
                Swal.fire({
                    title: 'Warning!',
                    text: 'ID Pegawai Wajib Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#id_pegawai").focus();
                });
                return false;
            } else if (nama_lengkap == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Nama Pegawai Wajib Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#nama_lengkap").focus();
                });
                return false;
            } else if (jabatan == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jabatan Wajib Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#jabatan").focus();
                });
                return false;
            } else if (no_hp == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'No HP Wajib Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#no_hp").focus();
                });
                return false;
            } else if (kode_dept == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Departemen Wajib Diisi!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    $("#kode_dept").focus();
                });
                return false;
            }
        });
    });
</script>
@endpush