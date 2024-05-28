<?php

namespace App\Filament\Resources\ConsultadaResource\Pages;

use App\Filament\Resources\ConsultadaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultada extends EditRecord
{
    protected static string $resource = ConsultadaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
