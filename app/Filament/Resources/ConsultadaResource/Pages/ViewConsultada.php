<?php

namespace App\Filament\Resources\ConsultadaResource\Pages;

use App\Filament\Resources\ConsultadaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConsultada extends ViewRecord
{
    protected static string $resource = ConsultadaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
