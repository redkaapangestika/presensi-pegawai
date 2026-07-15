<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            padding: 0;
        }

        .header p {
            margin: 5px 0 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .signature {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 30px;
        }

        .foto-pegawai {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h3>LAPORAN DATA PEGAWAI</h3>
        @if($departemen)
            <p>Departemen: {{ $departemen->nama_dept }}</p>
        @else
            <p>Seluruh Departemen</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>ID / NIK</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            @if($pegawai->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pegawai yang dapat ditampilkan.</td>
                </tr>
            @else
                @foreach($pegawai as $key => $d)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td>{{ $d->id_pegawai }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <td>{{ $d->jabatan }}</td>
                        <td>{{ $d->nama_dept }}</td>
                        <td>{{ $d->no_hp }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="signature">
        <p>Sleman, {{ date('d F Y') }}</p>
        <p style="margin-bottom: 70px;">Mengetahui,</p>
        <p><strong>Drs. Reno Candra S.</strong><br>Lurah Condongcatur</p>
    </div>
</body>

</html>