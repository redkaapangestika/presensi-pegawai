@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Atur Jadwal Kerja</h2>
                    <div class="text-muted mt-1">Manajemen jadwal kerja pegawai per hari</div>
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

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Kerja Standar</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped card-table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Keterangan</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwal as $j)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $j['hari'] }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-green-lt">{{ $j['jam_masuk'] }} WIB</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-red-lt">{{ $j['jam_pulang'] }} WIB</span>
                                        </td>
                                        <td>
                                            <span class="text-muted">Hari Kerja Normal</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editJadwal('{{ $j['hari'] }}', '{{ $j['jam_masuk'] }}', '{{ $j['jam_pulang'] }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path
                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" />
                                                </svg>
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Dinas Luar Pegawai</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped card-table">
                            <thead>
                                <tr>
                                    <th>ID Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Departemen</th>
                                    <th>Status Dinas Luar</th>
                                    <th>Lokasi Presensi (Abaikan Radius)</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawais as $p)
                                    <tr>
                                        <td><span class="badge bg-blue-lt">{{ $p->id_pegawai }}</span></td>
                                        <td>{{ $p->nama_lengkap }}</td>
                                        <td><span class="text-muted">{{ $p->nama_dept }}</span></td>
                                        <td>
                                            @if($p->is_dinas_luar)
                                                <span class="badge bg-green">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Dinas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $p->lokasi_dinas ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning"
                                                onclick="editDinasLuar('{{ $p->id_pegawai }}', '{{ $p->nama_lengkap }}', '{{ $p->is_dinas_luar }}', '{{ $p->lokasi_dinas }}')">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada data pegawai.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Edit Jadwal --}}
    <div class="modal modal-blur fade" id="modalEditJadwal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/petugas/jadwal">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Hari</label>
                            <input type="text" class="form-control" id="modal_hari" name="hari" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Masuk</label>
                            <input type="time" class="form-control" id="modal_jam_masuk" name="jam_masuk">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Pulang</label>
                            <input type="time" class="form-control" id="modal_jam_pulang" name="jam_pulang">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Edit Dinas Luar --}}
    <div class="modal modal-blur fade" id="modalDinasLuar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Status Dinas Luar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/petugas/dinasluar">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="hidden" id="modal_id_pegawai" name="id_pegawai">
                            <input type="text" class="form-control" id="modal_nama_pegawai" readonly disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-check form-switch cursor-pointer">
                                <input class="form-check-input my-auto" type="checkbox" id="modal_is_dinas_luar" name="is_dinas_luar" style="width: 2.5em; height: 1.25em;">
                                <span class="form-check-label ms-2 h3">Aktifkan Status Dinas Luar</span>
                            </label>
                            <small class="text-muted">Jika diaktifkan, pegawai dapat melakukan presensi tanpa batasan radius kantor pusat.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Info Lokasi Penugasan (Opsional)</label>
                            <textarea class="form-control" rows="2" id="modal_lokasi_dinas" name="lokasi_dinas" placeholder="Cth: Diklat di Balai Kota..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary me-auto"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Terapkan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        function editJadwal(hari, jam_masuk, jam_pulang) {
            document.getElementById('modal_hari').value = hari;
            document.getElementById('modal_jam_masuk').value = jam_masuk;
            document.getElementById('modal_jam_pulang').value = jam_pulang;
            var modal = new bootstrap.Modal(document.getElementById('modalEditJadwal'));
            modal.show();
        }

        function editDinasLuar(id, nama, is_dinas, lokasi) {
            document.getElementById('modal_id_pegawai').value = id;
            document.getElementById('modal_nama_pegawai').value = nama;
            document.getElementById('modal_is_dinas_luar').checked = is_dinas == 1 ? true : false;
            document.getElementById('modal_lokasi_dinas').value = lokasi || '';
            var modal = new bootstrap.Modal(document.getElementById('modalDinasLuar'));
            modal.show();
        }
    </script>
@endpush