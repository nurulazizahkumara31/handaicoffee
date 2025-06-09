<?php

namespace App\Filament\Resources\JasaResource\Pages;

use App\Filament\Resources\JasaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJasa extends EditRecord
{
    protected static string $resource = JasaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
