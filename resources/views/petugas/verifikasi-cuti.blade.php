@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Verifikasi Cuti / Izin</h2>
                    <div class="text-muted mt-1">Tinjau dan setujui/tolak pengajuan izin pegawai</div>
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

            {{-- Summary Cards --}}
            <div class="row row-deck row-cards mb-3">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="h1 mb-0 text-warning">
                                {{ $pengajuan->where('status_approved', '0')->count() }}
                            </div>
                            <div class="text-muted">Menunggu</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="h1 mb-0 text-success">
                                {{ $pengajuan->where('status_approved', '1')->count() }}
                            </div>
                            <div class="text-muted">Disetujui</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="h1 mb-0 text-danger">
                                {{ $pengajuan->where('status_approved', '2')->count() }}
                            </div>
                            <div class="text-muted">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Pengajuan Izin</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped card-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pegawai</th>
                                    <th>Departemen</th>
                                    <th>Tanggal Izin</th>
                                    <th>Jenis</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuan as $no => $p)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $p->nama_lengkap }}</td>
                                        <td><span class="badge bg-blue-lt">{{ $p->nama_dept }}</span></td>
                                        <td>{{ date('d M Y', strtotime($p->tgl_izin)) }}</td>
                                        <td>{{ ucfirst($p->status) }}</td>
                                        <td class="text-muted">{{ $p->keterangan }}</td>
                                        <td>
                                            @if($p->status_approved == '0')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($p->status_approved == '1')
                                                <span class="badge bg-success">Disetujui</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($p->status_approved == '0')
                                                <div class="btn-group">
                                                    <form id="form-approve-{{ $p->id }}" method="POST"
                                                        action="/petugas/verifikasi-cuti/update" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $p->id }}">
                                                        <input type="hidden" name="status_approved" value="1">
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            onclick="confirmApprove('form-approve-{{ $p->id }}', '{{ htmlspecialchars($p->nama_lengkap, ENT_QUOTES) }}', '{{ date('d M Y', strtotime($p->tgl_izin)) }}', '{{ ucfirst($p->status) }}', '{{ htmlspecialchars($p->keterangan, ENT_QUOTES) }}')">
                                                            ✓ Setujui
                                                        </button>
                                                    </form>
                                                    <form id="form-reject-{{ $p->id }}" method="POST"
                                                        action="/petugas/verifikasi-cuti/update" class="d-inline ms-1">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $p->id }}">
                                                        <input type="hidden" name="status_approved" value="2">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="confirmReject('form-reject-{{ $p->id }}', '{{ htmlspecialchars($p->nama_lengkap, ENT_QUOTES) }}', '{{ date('d M Y', strtotime($p->tgl_izin)) }}', '{{ ucfirst($p->status) }}', '{{ htmlspecialchars($p->keterangan, ENT_QUOTES) }}')">
                                                            ✕ Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted small">Sudah diproses</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            Belum ada pengajuan izin/cuti.
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
        function confirmApprove(formId, nama, tgl, jenis, keterangan) {
            Swal.fire({
                title: 'Setujui Pengajuan?',
                html: `
                        <div style="text-align:left; font-size:14px; background:#f8fafc; padding:15px; border-radius:8px; border:1px solid #e2e8f0; margin-bottom:10px;">
                            <b>Nama Pegawai:</b> ${nama}<br>
                            <b>Tgl Diajukan:</b> ${tgl}<br>
                            <b>Jenis Cuti:</b> ${jenis}<br>
                            <b>Keterangan:</b> ${keterangan}
                        </div>
                    `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmReject(formId, nama, tgl, jenis, keterangan) {
            Swal.fire({
                title: 'Tolak Pengajuan?',
                html: `
                        <div style="text-align:left; font-size:14px; background:#fee2e2; padding:15px; border-radius:8px; border:1px solid #fecaca; margin-bottom:15px; color: #991b1b;">
                            <b>Nama Pegawai:</b> ${nama}<br>
                            <b>Tgl Diajukan:</b> ${tgl}<br>
                            <b>Jenis Cuti:</b> ${jenis}<br>
                            <b>Keterangan:</b> ${keterangan}
                        </div>
                        <div style="text-align:left;">
                            <textarea id="alasan_tolak" class="swal2-textarea" style="margin: 0; width: 100%; height:80px; font-size:14px; border-radius:8px; padding:10px;" placeholder="Tuliskan alasan spesifik kenapa cuti ini ditolak (wajib)..."></textarea>
                        </div>
                    `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const alasan = document.getElementById('alasan_tolak').value;
                    if (!alasan) {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!');
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Inject hidden input
                    const inputAlasan = document.createElement("input");
                    inputAlasan.setAttribute("type", "hidden");
                    inputAlasan.setAttribute("name", "alasan_tolak");
                    inputAlasan.setAttribute("value", result.value);
                    document.getElementById(formId).appendChild(inputAlasan);

                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endpush