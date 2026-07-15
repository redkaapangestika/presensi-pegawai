<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Presensi</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

        body {
            font-family: 'Inter', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h3 {
            margin: 0 0 5px 0;
            text-transform: uppercase;
            font-size: 18px;
        }

        .header p {
            margin: 0;
            font-size: 14px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            font-size: 14px;
        }

        .presensi-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .presensi-table th,
        .presensi-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        .presensi-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .footer {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }

        .ttd {
            text-align: center;
            width: 250px;
        }

        .ttd p {
            margin-bottom: 70px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
                margin: 20px;
            }

            .header {
                border-bottom: 2px solid #000;
            }
        }

        .btn-print {
            padding: 10px 20px;
            background: #0284c7;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-family: 'Inter', Arial, sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <button onclick="window.print()" class="btn-print no-print">Cetak PDF / Print</button>

    <div class="header">
        <h3>Laporan Riwayat Presensi Bulanan</h3>
        <p>Kalurahan Condongcatur, Kecamatan Depok, Kabupaten Sleman</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%"><strong>ID Pegawai</strong></td>
            <td style="width: 2%">:</td>
            <td style="width: 33%">{{ $pegawai->id_pegawai }}</td>

            <td style="width: 15%"><strong>Bulan</strong></td>
            <td style="width: 2%">:</td>
            <td style="width: 33%">{{ $namabulan[$bulan] }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pegawai</strong></td>
            <td>:</td>
            <td>{{ $pegawai->nama_lengkap }}</td>

            <td><strong>Tahun</strong></td>
            <td>:</td>
            <td>{{ $tahun }}</td>
        </tr>
        <tr>
            <td><strong>Jabatan</strong></td>
            <td>:</td>
            <td>{{ $pegawai->jabatan }}</td>

            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="presensi-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto Masuk</th>
                <th>Jam Pulang</th>
                <th>Foto Pulang</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($histori->isEmpty())
                <tr>
                    <td colspan="7" style="padding: 20px;">Tidak ada riwayat presensi pada bulan ini.</td>
                </tr>
            @else
                @foreach ($histori as $loop => $d)
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td>
                            @if(!empty($d->foto_in))
                                <img src="{{ url($path_in) }}" alt="Foto Masuk"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $d->jam_out !== null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if(!empty($d->foto_out))
                                <img src="{{ url($path_out) }}" alt="Foto Pulang"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if ($d->jam_in > '08:00:00')
                                Terlambat
                            @else
                                Tepat Waktu
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Sleman, {{ date('d') }} {{ $namabulan[date('n')] }} {{ date('Y') }}<br>Karyawan Terkait</p>
            <br>
            <strong><u>{{ $pegawai->nama_lengkap }}</u></strong>
        </div>
    </div>

    <!-- Script to automatically print on page load -->
    <script>
        window.onload = function () {
            // Optional: Uncomment below line to auto print when page opens
            // window.print();
        }
    </script>
</body>

</html>