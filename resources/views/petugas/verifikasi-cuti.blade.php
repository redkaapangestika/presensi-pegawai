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
                                                    <form method="POST" action="/petugas/verifikasi-cuti/update" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $p->id }}">
                                                        <input type="hidden" name="status_approved" value="1">
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Setujui pengajuan ini?')">
                                                            ✓ Setujui
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="/petugas/verifikasi-cuti/update"
                                                        class="d-inline ms-1">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $p->id }}">
                                                        <input type="hidden" name="status_approved" value="2">
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Tolak pengajuan ini?')">
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