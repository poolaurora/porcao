<?php

namespace App\Filament\Resources\ReembolsosResource\Pages;

use App\Filament\Resources\ReembolsosResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReembolsos extends EditRecord
{
    protected static string $resource = ReembolsosResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
