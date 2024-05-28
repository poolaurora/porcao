<?php

namespace App\Filament\Resources\FullResource\Pages;

use App\Filament\Resources\FullResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFull extends ViewRecord
{
    protected static string $resource = FullResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
