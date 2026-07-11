@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Validasi Presensi</h2>
                    <div class="text-muted mt-1">Validasi data kehadiran pegawai</div>
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
                <div class="card-body">
                    <div class="row align-items-end g-2">
                        <div class="col-auto">
                            <label class="form-label">Pilih Tanggal</label>
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                        <path d="M16 3v4" />
                                        <path d="M8 3v4" />
                                        <path d="M4 11h16" />
                                    </svg>
                                </span>
                                <input type="text" id="tanggal" name="tanggal" value="{{ $today }}" class="form-control"
                                    placeholder="Pilih Tanggal" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" id="tabel-presensi">
                <div class="card-header">
                    <h3 class="card-title">Data Presensi — <span
                            id="label-tanggal">{{ date('d M Y', strtotime($today)) }}</span></h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped card-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pegawai</th>
                                    <th>Departemen</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Status Validasi</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-validasi">
                                @forelse($presensi as $no => $p)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $p->nama_lengkap }}</td>
                                        <td><span class="badge bg-blue-lt">{{ $p->nama_dept }}</span></td>
                                        <td>
                                            @if($p->jam_in)
                                                <span class="badge bg-green-lt">{{ $p->jam_in }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->jam_out)
                                                <span class="badge bg-red-lt">{{ $p->jam_out }}</span>
                                            @else
                                                <span class="text-muted">Belum checkout</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php $sv = $p->status_validasi ?? null; @endphp
                                            @if($sv == 'valid')
                                                <span class="badge bg-success">Valid</span>
                                            @elseif($sv == 'invalid')
                                                <span class="badge bg-danger">Tidak Valid</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Belum Divalidasi</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <form method="POST" action="/petugas/validasi-presensi/update" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $p->id }}">
                                                    <input type="hidden" name="status_validasi" value="valid">
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Tandai sebagai VALID?')">
                                                        ✓ Valid
                                                    </button>
                                                </form>
                                                <form method="POST" action="/petugas/validasi-presensi/update"
                                                    class="d-inline ms-1">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $p->id }}">
                                                    <input type="hidden" name="status_validasi" value="invalid">
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tandai sebagai TIDAK VALID?')">
                                                        ✕ Tidak Valid
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            Tidak ada data presensi untuk tanggal ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function () {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });

            $("#tanggal").change(function () {
                var tanggal = $(this).val();
                var parts = tanggal.split('-');
                var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $("#label-tanggal").text(parts[2] + ' ' + bulan[parseInt(parts[1]) - 1] + ' ' + parts[0]);

                $.ajax({
                    type: 'POST',
                    url: '/getpresensi-validasi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function (respond) {
                        $("#tbody-validasi").html(respond);
                    }
                });
            });
        });
    </script>
@endpush