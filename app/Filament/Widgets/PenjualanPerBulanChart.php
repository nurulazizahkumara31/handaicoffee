<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
// use App\Models\PenjualanBarang;

use Carbon\Carbon;

class PenjualanPerBulanChart extends ChartWidget
{
    // protected static ?string $heading = 'Penjualan Per Bulan '+date('Y'); // Judul widget chart
    protected static ?string $heading = null; // biarkan null

    public function getHeading(): string
    {
        return 'Penjualan Per Bulan ' . date('Y');
    }

    

    // Mendapatkan data untuk chart
    protected function getData(): array
    {
        // Tahun yang ingin ditampilkan
        $year = now()->year;

        // Ambil data total penjualan berdasarkan rumus (harga_jual - harga_beli) * jumlah
        $orders = Order::query()
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('produk', 'order_details.product_id', '=', 'produk.id_produk')
            ->where('orders.status', 'paid') // Hanya status 'bayar'
            ->whereYear('orders.created_at', $year)
            ->selectRaw('MONTH(orders.created_at) as month, SUM(order_details.subtotal * order_details.quantity) as total_penjualan')
            ->groupBy('month')
            ->pluck('total_penjualan', 'month');
            // dd($data); // untuk melihat data sebelum dikirim ke chart

         // Siapkan semua bulan (1–12)
         $allMonths = collect(range(1, 12));

         // Gabungkan semua bulan dengan hasil orders
        $data = $allMonths->map(function ($month) use ($orders) {
            return $orders->get($month, 0);
        });

        $labels = $allMonths->map(function ($month) {
            return Carbon::create()->month($month)->locale('id')->translatedFormat('F'); // Januari, Februari, ...
        });

        // Mengembalikan data dalam format yang dibutuhkan untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data, // Data untuk chart
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $labels, // Label untuk sumbu X
        ];
    }

    // Jenis chart yang digunakan, misalnya bar chart
    protected function getType(): string
    {
        return 'line'; // Tipe chart bisa diganti sesuai kebutuhan, seperti 'line', 'pie', dll.
    }
}