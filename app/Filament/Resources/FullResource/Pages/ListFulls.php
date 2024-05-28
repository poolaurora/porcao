<?php

namespace App\Filament\Resources\FullResource\Pages;

use App\Filament\Resources\FullResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFulls extends ListRecords
{
    protected static string $resource = FullResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
