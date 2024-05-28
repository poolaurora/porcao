<?php

namespace App\Filament\Resources\ReembolsosAdminResource\Pages;

use App\Filament\Resources\ReembolsosAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReembolsosAdmins extends ListRecords
{
    protected static string $resource = ReembolsosAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
