<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }} | Handai Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #0d9145;
            --light-green: #e7f8ed;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: var(--light-green);
            color: #333;
            font-size: 14px;
        }

        .invoice-container {
            background-color: #fff;
            padding: 30px;
            max-width: 720px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            height: 60px;
        }

        .header h2 {
            color: var(--primary-green);
            margin: 0;
        }

        .info {
            margin-top: 20px;
        }

        .info p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: var(--primary-green);
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
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
            color: #777;
            font-size: 12px;
        }

        .print-button {
            text-align: right;
            margin-bottom: 15px;
        }

        .print-button button {
            padding: 8px 16px;
            background-color: var(--primary-green);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
        
    </style>
    
</head>
<body>
<div class="flex justify-between items-center max-w-5xl mx-auto mb-4">
    <a href="{{ route('order.history') }}"
       class="inline-flex items-center gap-1 text-[var(--primary-green)] hover:text-green-700 text-sm font-semibold transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back
    </a>

    <button onclick="window.print()"
            class="px-4 py-2 bg-[var(--primary-green)] text-white rounded font-semibold text-sm print:hidden">
        Cetak Invoice
    </button>
</div>

    <div class="invoice-container">
        <div class="header">
            <img src="{{ asset('images/logocoffee2.png') }}" alt="Handai Coffee Logo">
            <h2><b>INVOICE PEMBAYARAN</b></h2>
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
            Terima kasih atas kepercayaan Anda pada Handai Coffee!<br>
            Boost Your Study, Sustain Your Health!
        </div>
    </div>
</body>
</html>
