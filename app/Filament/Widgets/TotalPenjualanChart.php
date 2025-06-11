<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

// use App\Models\PenjualanBarang;

class TotalPenjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan'; // Judul widget chart

    // Mendapatkan data untuk chart
    protected function getData(): array
    {
        // Ambil data total penjualan berdasarkan rumus (harga_jual - harga_beli) * jumlah
        $data = Order::query()
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('produk', 'order_details.product_id', '=', 'produk.id_produk')
            ->where('orders.status', 'paid') // Hanya status 'bayar'
            ->selectRaw('produk.name_product, SUM(order_details.subtotal * order_details.quantity) as total_penjualan')
            ->groupBy('produk.name_product')
            ->get()
            ->map(function ($penjualan) {
                return [
                    'name_product' => $penjualan->name_product,
                    'total_penjualan' => $penjualan->total_penjualan,
                ];
            });
            // dd($data); // untuk melihat data sebelum dikirim ke chart

        // Pastikan data ada sebelum dikirim ke chart
        if ($data->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Mengembalikan data dalam format yang dibutuhkan untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data->pluck('total_penjualan')->toArray(), // Data untuk chart
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $data->pluck('name_product')->toArray(), // Label untuk sumbu X
        ];
    }

    // Jenis chart yang digunakan, misalnya bar chart
    protected function getType(): string
    {
        return 'bar'; // Tipe chart bisa diganti sesuai kebutuhan, seperti 'line', 'pie', dll.
    }
}