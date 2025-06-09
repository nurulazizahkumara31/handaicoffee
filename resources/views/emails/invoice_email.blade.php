<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>
    <h2>Invoice Pembayaran</h2>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
    <p><strong>Tanggal:</strong> {{ $order->updated_at->format('d-m-Y H:i') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

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

    <p><strong>Ongkos Kirim:</strong> Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</p>
    <p><strong>Diskon Voucher:</strong> Rp{{ number_format($order->voucher_discount, 0, ',', '.') }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
</body>
</html>
