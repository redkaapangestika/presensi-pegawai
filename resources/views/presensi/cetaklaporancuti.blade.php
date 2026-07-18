<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Cuti</title>

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

        .presensi-table td {
            text-transform: capitalize;
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
        <h3>Laporan Riwayat Cuti dan Izin Pegawai</h3>
        <p>Kalurahan Condongcatur, Kecamatan Depok, Kabupaten Sleman</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%"><strong>ID Pegawai</strong></td>
            <td style="width: 2%">:</td>
            <td style="width: 33%">{{ $pegawai->id_pegawai }}</td>

            <td style="width: 15%"><strong>Dicetak Tanggal</strong></td>
            <td style="width: 2%">:</td>
            <td style="width: 33%">{{ date('d-m-Y') }}</td>
        </tr>
        <tr>
            <td><strong>Nama Pegawai</strong></td>
            <td>:</td>
            <td>{{ $pegawai->nama_lengkap }}</td>

            <td></td>
            <td></td>
            <td></td>
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
                <th>Tanggal Cuti / Izin</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Status Persetujuan</th>
            </tr>
        </thead>
        <tbody>
            @if ($histori->isEmpty())
                <tr>
                    <td colspan="5" style="padding: 20px;">Tidak ada riwayat cuti / izin yang diajukan.</td>
                </tr>
            @else
                @foreach ($histori as $loop => $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date("d-m-Y", strtotime($d->tgl_izin)) }}</td>
                        <td>{{ $d->status == "s" ? "Sakit" : "Izin / Cuti" }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>
                            @if($d->status_approved == "0")
                                <span style="color: #f59e0b; font-weight: bold;">Menunggu</span>
                            @elseif($d->status_approved == "1")
                                <span style="color: #10b981; font-weight: bold;">Disetujui</span>
                            @else
                                <span style="color: #ef4444; font-weight: bold;">Ditolak</span>
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

</body>

</html>