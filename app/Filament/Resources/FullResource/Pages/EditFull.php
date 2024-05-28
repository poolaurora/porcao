<?php

namespace App\Filament\Resources\FullResource\Pages;

use App\Filament\Resources\FullResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFull extends EditRecord
{
    protected static string $resource = FullResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
