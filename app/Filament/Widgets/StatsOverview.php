<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Infos;

class StatsOverview extends BaseWidget
{

    protected static ?string $pollingInterval = '5s';

    protected function getStats(): array
    {
        // Calcular a contagem de novos usuários para cada um dos últimos 7 dias
        $statsUser = collect(range(6, 0))->map(function ($day) {
            return User::whereDate('created_at', Carbon::today()->subDays($day))->count();
        })->toArray();

        $statsInfo = collect(range(6, 0))->map(function ($day) {
            return Infos::whereDate('created_at', Carbon::today()->subDays($day))->count();
        })->toArray();

        $usersWithoutRolesCount = User::doesntHave('roles')->count();

        // Criar os objetos Stat com os dados adequados
        return [
            Stat::make('Usuários', $usersWithoutRolesCount)
                ->color('success')
                ->chart($statsUser), // Inclui os dados de contagem diária no gráfico

            Stat::make('Infos No Painel', Infos::where('is_published', 1)->count())
            ->color('success')
            ->chart($statsInfo),

            Stat::make('Telas Onlines', '1'),
        ];
    }
}
