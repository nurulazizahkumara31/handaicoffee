<?php

namespace App\Filament\Resources\PresensiResource\Pages;

use App\Filament\Resources\PresensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use App\Filament\Resources\PegawaiResource;

class ListPresensis extends ListRecords
{
    protected static string $resource = PresensiResource::class;

protected function getHeaderActions(): array
{
    return [
        Action::make('Export PDF')
            ->label('Unduh PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->url(route('presensi.export.pdf'))
            ->openUrlInNewTab()
            ->color('success'),

        Action::make('New Pegawai')
            ->label('New Pegawai')
            ->icon('heroicon-o-user-plus')
            ->url(PresensiResource::getUrl('create')) // menggunakan Filament resource
            ->color('primary'),
    ];
}

    }

