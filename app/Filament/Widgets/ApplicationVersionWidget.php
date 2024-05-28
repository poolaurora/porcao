<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ApplicationVersionWidget extends Widget
{
    protected static string $view = 'filament.widgets.application-version-widget';

    protected function viewData(): array
    {
        return [
            'version' => config('app.version'),  // Certifique-se que a configuração 'version' está definida em config/app.php
        ];
    }
}
