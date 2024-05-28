<?php

namespace App\Filament\Resources\ConsultadaResource\Pages;

use App\Filament\Resources\ConsultadaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultadas extends ListRecords
{
    protected static string $resource = ConsultadaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
