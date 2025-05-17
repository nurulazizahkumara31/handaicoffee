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
     //
    }
}
