<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }} | Handai Coffee</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #0d9145;
            --light-green: #f0fdf4;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-green);
            color: #333;
            font-size: 13px;
        }

        .invoice-container {
            background-color: #fff;
            padding: 25px;
            max-width: 700px;
            margin: auto;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .header img {
            height: 50px;
        }

        .header h2 {
            color: var(--primary-green);
            margin: 0;
            font-size: 20px;
            text-align: right;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 4px 0;
        }

        h4 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: var(--primary-green);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: var(--primary-green);
            color: white;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-section p {
            margin: 4px 0;
        }

        .total-section strong {
            display: inline-block;
            width: 180px;
        }

        .footer {
            margin-top: 35px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <img src="{{ public_path('images/logocoffee2.png') }}" alt="Handai Coffee Logo">
            <h2>INVOICE</h2>
        </div>

        <div class="info">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
            <p><strong>Tanggal:</strong> {{ $order->updated_at->format('d-m-Y H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
        </div>

        <h4>Detail Produk</h4>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->name_product }}</td>
                    <td>Rp{{ number_format($detail->product->price, 0, ',', '.') }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p><strong>Ongkos Kirim:</strong> Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
            <p><strong>Diskon Voucher:</strong> Rp{{ number_format($order->voucher_discount, 0, ',', '.') }}</p>
            <p><strong>Total:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>

        <div class="footer">
            Terima kasih atas kepercayaan Anda kepada Handai Coffee ☕<br>
            Boost Your Study, Sustain Your Health!
        </div>
    </div>
</body>
</html>
