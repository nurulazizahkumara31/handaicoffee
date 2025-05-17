<!DOCTYPE html>
<html>
<head>
    <title>Presensi PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #222;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .status-hadir {
            background-color: #d4edda;
            color: #155724;
        }
        .status-terlambat {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-absen {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>Daftar Presensi</h2>
    <h2>Handai Coffee</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Pegawai</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensis as $presensi)
                <tr class="
                    @if($presensi->status == 'Hadir') status-hadir
                    @elseif($presensi->status == 'Terlambat') status-terlambat
                    @elseif($presensi->status == 'Absen') status-absen
                    @endif
                ">
                    <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $presensi->pegawai->nama_pegawai ?? '-' }}</td>
                    <td>{{ $presensi->jam_masuk ?? '-' }}</td>
                    <td>{{ $presensi->jam_keluar ?? '-' }}</td>
                    <td>{{ $presensi->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
