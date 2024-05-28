<?php

namespace App\Filament\Resources\ConsultaveisAdminResource\Pages;

use App\Filament\Resources\ConsultaveisAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultaveisAdmins extends ListRecords
{
    protected static string $resource = ConsultaveisAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
