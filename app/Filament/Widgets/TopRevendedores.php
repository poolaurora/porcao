<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class TopRevendedores extends BaseWidget
{

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::select('users.*', DB::raw('COUNT(payments.id) as purchases_count'))
                    ->leftJoin(
                        'payments',
                        function ($join) {
                            // Filtrando pagamentos pelo status e user_id
                            $join->on(DB::raw("json_extract(payments.description, '$.info.user_id')"), '=', 'users.id')
                                 ->where('status', '=', 'aprovado');
                        }
                    )
                    ->groupBy('users.id')
                    ->orderBy('purchases_count', 'desc') // Ordenar pela quantidade de compras, maior primeiro
                    ->limit(5) // Mostrar apenas os 5 primeiros
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Nome'),
                TextColumn::make('purchases_count')
                    ->label('Infos Compradas')
                    ->sortable(),
            ])->paginated(false);
    }
}
