<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

use App\Models\Order;
use App\Models\Coa;
use App\Models\pelanggan;
use Illuminate\Support\Number;
use Carbon\Carbon;

class DashboardStatCards extends BaseWidget
{
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $isBusinessCustomersOnly = $this->filters[' businessCustomersOnly'] ?? null;

        $businessCustomerMultiplier = match (true) {
            boolval($isBusinessCustomersOnly) => 2 / 3,
            blank($isBusinessCustomersOnly) => 1,
            default => 1 / 3,
        };

        $diffInDays = $startDate ? $startDate->diffInDays($endDate) : 0;

        $revenue = (int) (($startDate ? ($diffInDays * 137) : 192100) * $businessCustomerMultiplier);
        $newCustomers = (int) (($startDate ? ($diffInDays * 7) : 1340) * $businessCustomerMultiplier);
        $newOrders = (int) (($startDate ? ($diffInDays * 13) : 3543) * $businessCustomerMultiplier);

        // Fungsi lokal untuk format rupiah
        $rupiah = fn($angka) => 'Rp ' . number_format($angka, 0, ',', '.');

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };

        return [
            Stat::make('Total Pembeli', pelanggan::count())
                ->description('Jumlah pembeli terdaftar'),

            Stat::make('Total Transaksi', Order::count())
                ->description('Jumlah transaksi'),

            Stat::make('Total Penjualan', $rupiah(
                Order::query()
                    ->where('status', 'paid')
                    ->sum('total_price')
            ))
                ->description('Jumlah transaksi terbayar'),

            Stat::make('Total Keuntungan', $rupiah(
                Order::query()
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('status', 'paid')
                    ->selectRaw('SUM((order_details.subtotal - order_details.price) * order_details.quantity) as total_penjualan')
                    ->value('total_penjualan')
            ))
                ->description('Jumlah keuntungan'),

            Stat::make('Revenue', '$' . $formatNumber($revenue))
                ->description('32k increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }

    protected function getCards(): array
    {
        return [
            // Contoh jika ingin menambahkan card custom
            // Card::make('Total Pendapatan', 'Rp ' . number_format(\App\Models\Transaksi::sum('total')))
            //     ->description('Total uang masuk')
            //     ->color('success'),

            // Card::make('Jumlah Akun COA', Coa::count())
            //     ->description('Data akun aktif')
            //     ->color('warning'),
        ];
    }
}
