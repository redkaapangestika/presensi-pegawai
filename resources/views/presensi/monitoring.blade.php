@extends('layouts.admin.tabler')
@section('content')
    <style>
        .monitoring-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .table-custom th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom td {
            vertical-align: middle;
            color: #334155;
        }

        .table-custom tr {
            transition: background-color 0.2s;
        }

        .table-custom tr:hover {
            background-color: #f1f5f9 !important;
        }

        .input-icon-addon {
            color: #64748b;
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control-custom:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3748;
        }
    </style>
    <div class="page-header d-print-none mb-4 mt-3">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle text-primary fw-bold mb-1">Presensi Hari Ini</div>
                    <h2 class="page-title text-dark">
                        Monitoring Presensi
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card monitoring-card">
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold text-secondary mb-2">Pilih Tanggal Presensi</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="icon">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M7 14h.013" />
                                                <path d="M10.01 14h.005" />
                                                <path d="M13.01 14h.005" />
                                                <path d="M16.015 14h.005" />
                                                <path d="M13.015 17h.005" />
                                                <path d="M7.01 17h.005" />
                                                <path d="M10.01 17h.005" />
                                            </svg>
                                        </span>
                                        <input type="text" id="tanggal" name="tanggal" value=""
                                            class="form-control form-control-custom" placeholder="YYYY-MM-DD"
                                            autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-custom">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Id Pegawai</th>
                                                    <th>Nama Pegawai</th>
                                                    <th>Departemen</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Foto Masuk</th>
                                                    <th>Jam Keluar</th>
                                                    <th>Foto Keluar</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="loadpresensi">
                                                <tr>
                                                    <td colspan="9" class="text-center py-5 text-muted">
                                                        Silakan pilih tanggal untuk menampilkan data presensi
                                                    </td>
                                                </tr>
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

            $("#tanggal").change(function (e) {
                var tanggal = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi'
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , tanggal: tanggal
                    },
                    cache: false,
                    success: function (respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            });
        });
    </script>
@endpush