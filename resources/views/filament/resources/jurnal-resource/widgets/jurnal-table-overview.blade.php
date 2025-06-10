<?php

if (!function_exists('rupiah')) {
    function rupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}
?>

<x-filament-widgets::widget>
    <x-filament::section>

        <div class="overflow-x-auto">

            <!-- CSS untuk baris hijau-putih dan warna teks -->
            <style>
                .row-green:nth-child(odd) {
                    background-color: #e6f4ea; /* Hijau muda */
                }
                .row-green:nth-child(even) {
                    background-color: #ffffff; /* Putih */
                }
                .text-hijau-tua {
                    color: #166534; /* Tailwind green-800 */
                }
            </style>

            <!-- Filter Periode -->
            <div class="flex items-center justify-start mb-4 space-x-2">
                <label for="periode" class="font-semibold">Pilih Periode:</label>
                <input type="month" wire:model="periode" id="periode" class="border rounded px-2 py-1">
                <x-filament::button type="submit" wire:click.prevent="filterJurnal" color="success" icon="heroicon-m-magnifying-glass">
                    Filter
                </x-filament::button>
            </div>

            <!-- Judul -->
            <div class="text-center leading-tight mb-4">
                <div class="text-hijau-tua text-lg font-bold">Handai Coffee</div>
                <div class="text-hijau-tua text-lg font-bold">Jurnal Umum</div>
                <div class="text-hijau-tua font-semibold">
                    Periode {{ $periode ? \Carbon\Carbon::createFromFormat('Y-m', $periode)->translatedFormat('F Y') : now()->translatedFormat('F Y') }}
                </div>
            </div>

            <!-- Tabel -->
            <table class="w-full text-sm text-left border border-gray-200">
                <thead class="bg-green-200 text-xs uppercase">
                    <tr>
                        <th class="px-4 py-2 border">ID Jurnal</th>
                        <th class="px-4 py-2 border">Nomor</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Akun</th>
                        <th class="px-4 py-2 border">Ref</th>
                        <th class="px-4 py-2 border">Debet</th>
                        <th class="px-4 py-2 border">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnals as $jurnal)
                        @foreach($jurnal->jurnaldetail as $detail)
                            <tr class="row-green">
                                <td class="px-4 py-2 border">{{ $jurnal->id }}</td>
                                <td class="px-4 py-2 border">{{ $jurnal->no_referensi }}</td>
                                <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($jurnal->tgl)->format('Y-m-d') }}</td>

                                @if($detail->debit != 0)
                                    <td class="px-4 py-2 border">{{ $detail->coa->nama_akun ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $detail->coa->kode_akun }}</td>
                                    <td class="px-4 py-2 border text-right">{{ rupiah($detail->debit) }}</td>
                                @else
                                    <td class="px-4 py-2 border">&nbsp;&nbsp;&nbsp;{{ $detail->coa->nama_akun ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $detail->coa->kode_akun }}</td>
                                    <td class="px-4 py-2 border text-right"></td>
                                @endif

                                @if($detail->credit != 0)
                                    <td class="px-4 py-2 border text-right">{{ rupiah($detail->credit) }}</td>
                                @else
                                    <td class="px-4 py-2 border text-right"></td>
                                @endif
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="font-semibold bg-green-200">
                        <td colspan="5" class="text-right px-4 py-2 border">Total</td>
                        <td class="text-right px-4 py-2 border">
                            {{ rupiah($jurnals->flatMap->jurnaldetail->sum('debit')) }}
                        </td>
                        <td class="text-right px-4 py-2 border">
                            {{ rupiah($jurnals->flatMap->jurnaldetail->sum('credit')) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
