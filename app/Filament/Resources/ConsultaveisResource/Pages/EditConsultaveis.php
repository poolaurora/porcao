<?php

namespace App\Filament\Resources\ConsultaveisResource\Pages;

use App\Filament\Resources\ConsultaveisResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultaveis extends EditRecord
{
    protected static string $resource = ConsultaveisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
