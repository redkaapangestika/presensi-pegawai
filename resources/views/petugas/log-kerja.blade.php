@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Evaluasi Data Kerja Harian
                </h2>
                <div class="text-muted mt-1">Review ringkasan kinerja harian dan berkas fisik bukti kegiatan pegawai.</div>
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
                        <div class="row mb-3 align-items-center">
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h16" />
                                            <path d="M11 15h1" />
                                            <path d="M12 15v3" />
                                        </svg>
                                    </span>
                                    <input type="text" value="{{ date('Y-m-d') }}" class="form-control"
                                        placeholder="Pilih Tanggal" id="tanggal" name="tanggal" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-12 col-md-8 text-md-end text-start">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddLog">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <line x1="12" y1="5" x2="12" y2="19"></line>
                                      <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Tambah Target / Log
                                </a>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai / Jabatan</th>
                                        <th>Departemen</th>
                                        <th>Jam Pulang</th>
                                        <th>Log Kinerja / Ringkasan Pekerjaan</th>
                                        <th>Lampiran Berkas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="loadlogkerja">
                                    {{-- Data injected via ajax --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Add Log -->
<div class="modal modal-blur fade" id="modalAddLog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambahkan Tugas / Log Kerja Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/petugas/log-kerja/store" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tgl_presensi" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pegawai</label>
                        <select name="id_pegawai" class="form-select" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $peg)
                                <option value="{{ $peg->id_pegawai }}">{{ $peg->nama_lengkap }} ({{ $peg->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uraian Tugas / Log Kinerja</label>
                        <textarea class="form-control" name="log_kerja" rows="4" placeholder="Tuliskan keterangan detail terkait log kinerja atau tugas harian ini..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Histori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Log -->
<div class="modal modal-blur fade" id="modalEditLog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Log Kinerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/petugas/log-kerja/update" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_presensi" id="edit_id_presensi">
                    <div class="mb-3">
                        <label class="form-label">Uraian Tugas / Log Kinerja</label>
                        <textarea class="form-control" name="log_kerja" id="edit_log_kerja" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function() {
        $("#tanggal").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(e) {
            loadlogkerja();
        });

        function loadlogkerja() {
            var tanggal = $("#tanggal").val();
            $.ajax({
                type: 'POST',
                url: '/getlogkerja',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond) {
                    $("#loadlogkerja").html(respond);
                }
            });
        }

        // Tampilkan default saat halaman pertama dimuat
        loadlogkerja();
    });

    function editLog(id, log_text) {
        document.getElementById('edit_id_presensi').value = id;
        document.getElementById('edit_log_kerja').value = log_text;
        var myModal = new bootstrap.Modal(document.getElementById('modalEditLog'));
        myModal.show();
    }

    function confirmDeleteLog(formId) {
        Swal.fire({
            title: 'Konfirmasi Penghapusan',
            text: 'Apakah Anda yakin ingin menghapus catatan log dan berkas kerja ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush