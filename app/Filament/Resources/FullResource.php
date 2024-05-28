<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FullResource\Pages;
use App\Filament\Resources\FullResource\RelationManagers;
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

class FullResource extends Resource
{
    protected static ?string $model = Infos::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Estoque';

    protected static ?string $navigationLabel = 'Full';


    public static function getNavigationBadge(): ?string
    {
        return Infos::where('categoria', 'full')->where('is_published', true)->count(); // Retorna o número total de registros
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
            Tables\Columns\TextColumn::make('valor')
                ->label('Valor')
                ->money('BRL')
                ->sortable(),
        ])
            ->query($query)
            ->filters([
                
            ])
            ->actions([
                ButtonAction::make('comprar')
                    ->label('Comprar')
                    ->action(function ($record) {
                        // Este callback só será chamado após o usuário confirmar no modal
                        return redirect()->route('create.payment', [
                            'id' => $record->id, 
                            'type' => 'full',
                        ]);
                    })
                    ->requiresConfirmation() // Solicita confirmação antes de executar a ação
                    ->modalHeading('Confirmar Compra')
                    ->modalSubheading('Você tem certeza que deseja realizar esta compra?'),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
            ]);
    }

    protected static function getQuery()
    {
        return Infos::where('categoria', 'full')->where('is_published', true);
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
            'index' => Pages\ListFulls::route('/'),
        ];
    }
}
