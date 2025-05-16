<?php

namespace App\Filament\Resources\PembelianResource\Pages;

use App\Filament\Resources\PembelianResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\BahanBaku;

class EditPembelian extends EditRecord
{
    protected static string $resource = PembelianResource::class;

    protected function afterSave(): void
    {
        if ($this->record->wasChanged('status') && $this->record->status === 'lengkap') {
            foreach ($this->record->detailPembelian as $item) {
                $bahanBaku = BahanBaku::find($item->kode_bahan_baku);
                if ($bahanBaku) {
                    $bahanBaku->increment('jumlah', $item->jumlah);
                }
            }
        }
    }
}
