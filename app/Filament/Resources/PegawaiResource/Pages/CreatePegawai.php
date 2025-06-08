<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use App\Filament\Resources\PresensiResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePegawai extends CreateRecord
{
    protected static string $resource = PegawaiResource::class;

    protected function getRedirectUrl(): string
    {
        // Cek apakah berasal dari tombol di Presensi
        if (request()->query('from_presensi')) {
            return PresensiResource::getUrl('create') . '?pegawai_id=' . $this->record->id_pegawai;
        }

        // Default jika dari tempat lain
        return PegawaiResource::getUrl();
    }
}
