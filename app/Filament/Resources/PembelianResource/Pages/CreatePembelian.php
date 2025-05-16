<?php

namespace App\Filament\Resources\PembelianResource\Pages;

use App\Filament\Resources\PembelianResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\BahanBaku;

class CreatePembelian extends CreateRecord
{
    protected static string $resource = PembelianResource::class;

    protected function afterCreate(): void
    {
        // Debug log (sementara)
        logger('afterCreate dipanggil. Status: ' . $this->record->status);

        if ($this->record->status === 'lengkap') {
            foreach ($this->record->detailPembelian as $item) {
                $bahanBaku = BahanBaku::find($item->kode_bahan_baku);
                if ($bahanBaku) {
                    $bahanBaku->increment('jumlah', $item->jumlah);
                }
            }
        }
    }
}
