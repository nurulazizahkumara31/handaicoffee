<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
            font-size: 14px;
        }

        .invoice-container {
            background-color: #fff;
            padding: 30px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table thead {
            background-color: #007BFF;
            color: white;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .total-section p {
            margin: 5px 0;
        }

        .total-section p strong {
            display: inline-block;
            width: 180px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #888;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <h2>Invoice Pembayaran</h2>

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
                @foreach ($order->details as $detail)
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
            Terima kasih atas pembelian Anda!
        </div>
    </div>
</body>
</html>
