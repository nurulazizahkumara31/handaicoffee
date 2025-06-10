<?php
if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Pembelian</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
            background-color: #ffffff;
            color: #333;
            margin: 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-height: 20px;
        }

        h2 {
            text-align: center;
            margin: 0;
            color: #2f855a;
        }

        h2 + h2 {
            margin-bottom: 20px;
            font-size: 16px;
            color: #4a5568;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px 8px;
            text-align: left;
        }

        th {
            background-color: #38a169;
            color: white;
            text-transform: uppercase;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f7fafc;
        }

        tr:hover {
            background-color: #e6fffa;
        }

        .text-right {
            text-align: right;
        }

        .status-lengkap {
            color: #2f855a;
            font-weight: bold;
        }

        .status-belum {
            color: #c53030;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ public_path('storage/images/logo.png') }}" alt="Logo Handai Coffee">
    </div>

    <h2>Daftar Pembelian</h2>
    <h2>Handai Coffee</h2>

    <table>
        <thead>
            <tr>
                <th>No Invoice</th>
                <th>Nama Supplier</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelian as $p)
            <tr>
                <td>{{ $p->no_invoice }}</td>
                <td>{{ optional($p->supplier)->nama_supplier ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                <td class="text-right">{{ rupiah($p->total) }}</td>
                <td class="{{ $p->status == 'lengkap' ? 'status-lengkap' : 'status-belum' }}">
                    {{ ucfirst($p->status) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
