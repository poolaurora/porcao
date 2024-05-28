<?php

namespace App\Filament\Resources\ConsultaveisAdminResource\Pages;

use App\Filament\Resources\ConsultaveisAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultaveisAdmin extends EditRecord
{
    protected static string $resource = ConsultaveisAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
