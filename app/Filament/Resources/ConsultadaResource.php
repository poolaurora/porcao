<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultadaResource\Pages;
use App\Filament\Resources\ConsultadaResource\RelationManagers;
use App\Models\Infos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use Filament\Tables\Actions\ButtonAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\View;

class ConsultadaResource extends Resource
{
    protected static ?string $model = Infos::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Estoque';

    protected static ?string $navigationLabel = 'Consultada';


    public static function getNavigationBadge(): ?string
    {
        return Infos::where('categoria', 'consultada')->where('is_published', true)->count(); // Retorna o número total de registros
    }



    public static function canEdit($record): bool
    {
        return auth()->user()->can('view gestao');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('view gestao');
    }

    public static function canCreate(): bool
    {
        return false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {

        $query = static::getQuery();

        return $table
        ->columns([
            Tables\Columns\TextColumn::make('ccn')
                ->label('BIN')
                ->limit(6, ''),
            Tables\Columns\TextColumn::make('banco')
                ->label('BANCO')
                ->searchable(),
            Tables\Columns\TextColumn::make('senha6')
                ->label('Senha De 6')
                ->searchable()
                ->getStateUsing(function ($record) {
                    return $record->senha6 === null ? 'Não' : 'Sim';
                }),
            Tables\Columns\TextColumn::make('genero')
                ->label('Gênero')
                ->searchable(),
            Tables\Columns\TextColumn::make('limite')
                ->label('Limite')
                ->sortable()
                ->money('BRL'),
            Tables\Columns\TextColumn::make('valor')
                ->label('Valor')
                ->money('BRL')
                ->sortable(),
        ])
        ->query($query)
        ->filters([
            Filter::make('1k-2k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [1000, 2000])),
            Filter::make('2k-3k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [2000, 3000])),
            Filter::make('3k-4k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [3000, 4000])),
            Filter::make('4k-5k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [4000, 5000])),
            Filter::make('5k-6k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [5000, 6000])),
            Filter::make('6k-7k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [6000, 7000])),
            Filter::make('7k-8k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [7000, 8000])),
            Filter::make('8k-9k')
            ->query(fn (Builder $query) => $query->whereBetween('limite', [8000, 9000])),
            Filter::make('10k+')
            ->query(fn (Builder $query) => $query->where('limite', '>=', 10000))
        ])
            ->actions([
                ButtonAction::make('comprar')
                ->label('Comprar')
                ->action(function ($record) {
                    // Este callback só será chamado após o usuário confirmar no modal
                    return redirect()->route('create.payment', [
                        'id' => $record->id, 
                        'type' => 'consultada'
                    ]);
                })
                ->requiresConfirmation() // Solicita confirmação antes de executar a ação
                ->modalHeading('Confirmar Compra')
                ->modalContent(View::make('modals.confirmar_compra')),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    protected static function getQuery()
    {
        return Infos::where('categoria', 'consultada')->where('is_published', true);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsultadas::route('/'),
        ];
    }
}
