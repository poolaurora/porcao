<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class InfosCostumerChart extends ChartWidget
{
    protected static ?string $heading = 'Infos Compradas';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $userId = auth()->id();
        $data = DB::table('payments')
            ->whereJsonContains('description->info', ['user_id' => $userId])
            ->where('status', 'aprovado')
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->get()
            ->keyBy('date');  // Use keyBy para facilitar o acesso direto por data
    
        // Preparar os dados para o gráfico
        $dailyData = [];
        $labels = [];
    
        for ($i = 0; $i <= 6; $i++) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $labels[] = $date;  // Adiciona a data ao array de labels
            // Buscar a contagem para a data específica, ou 0 se não houver registro
            $dailyData[] = $data->get($date)->count ?? 0;
        }
    
        // Reverter os arrays para que os dias estejam em ordem cronológica (do mais antigo para o mais recente)
        $labels = array_reverse($labels);
        $dailyData = array_reverse($dailyData);
    
        return [
            'datasets' => [
                [
                    'label' => 'Compras de Infos',
                    'data' => $dailyData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }
    


    protected function getType(): string
    {
        return 'line';
    }
}
