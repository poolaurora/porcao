<?php

namespace App\Filament\Resources\ConsultaveisResource\Pages;

use App\Filament\Resources\ConsultaveisResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConsultaveis extends ViewRecord
{
    protected static string $resource = ConsultaveisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
