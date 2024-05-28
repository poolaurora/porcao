<?php

namespace App\Filament\Resources\ConsultaveisResource\Pages;

use App\Filament\Resources\ConsultaveisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultaveis extends ListRecords
{
    protected static string $resource = ConsultaveisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
