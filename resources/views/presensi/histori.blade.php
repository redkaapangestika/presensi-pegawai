@extends('layouts.presensi')
@section('header')
    <style>
        .appHeader.bg-primary {
            background: #0284c7 !important;
            border: none;
            box-shadow: none;
        }

        .filter-container {
            padding: 80px 20px 20px 20px;
            background: white;
        }

        .form-group-custom {
            margin-bottom: 15px;
        }

        .form-group-custom label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 5px;
            display: block;
        }

        .form-control-custom {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 0.9rem;
            width: 100%;
            color: #4b5563;
        }

        .export-btn-container {
            position: fixed;
            bottom: 80px;
            left: 0;
            width: 100%;
            padding: 0 20px;
            z-index: 10;
        }

        .btn-export {
            background: #ffffff;
            color: #0284c7;
            border: 2px solid #0284c7;
            border-radius: 12px;
            padding: 15px;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            box-shadow: 0 4px 6px rgba(2, 132, 199, 0.1);
            transition: all 0.2s;
        }

        .btn-export:active {
            background: #0284c7;
            color: white;
        }

        body.dark-mode .btn-export {
            background: #1f2937;
            color: #38bdf8;
            border-color: #38bdf8;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Riwayat Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="filter-container">
        <div class="row">
            <div class="col-6">
                <div class="form-group-custom">
                    <label>Bulan</label>
                    <select name="bulan" id="bulan" class="form-control-custom">
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>{{ $namabulan[$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group-custom">
                    <label>Tahun</label>
                    <select name="tahun" id="tahun" class="form-control-custom">
                        <option value="">Pilih Tahun</option>
                        @php
                            $tahunmulai = 2023;
                            $tahunsekarang = date('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                            <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="px-3" style="margin-bottom: 140px;">
        <div id="tampildata"></div>
    </div>

    <div class="export-btn-container">
        <button type="button" id="btn-export" class="btn-export">Export Laporan Pribadi</button>
    </div>
@endsection

@push('myscript')
    <script>
        $(function () {
            function loadHistori() {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();

                $("#tampildata").html('<div class="text-center mt-3"><div class="spinner-border text-primary" role="status"></div></div>');

                $.ajax({
                    type: 'POST',
                    url: 'gethistori',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function (respond) {
                        $("#tampildata").html(respond);
                    }
                });
            }

            // Auto load histori saat halaman dibuka
            loadHistori();

            // Load ulang saat filter diubah
            $("#bulan, #tahun").change(function () {
                loadHistori();
            });

            // Action cetak laporan
            $("#btn-export").click(function () {
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();

                if (bulan == "" || tahun == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Silahkan pilih bulan dan tahun terlebih dahulu',
                        icon: 'warning'
                    });
                    return false;
                }

                // Open route print laporan in new tab
                window.open("/presensi/cetaklaporan?bulan=" + bulan + "&tahun=" + tahun, '_blank');
            });
        });
    </script>
@endpush