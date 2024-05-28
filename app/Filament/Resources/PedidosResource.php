<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PedidosResource\Pages;
use App\Filament\Resources\PedidosResource\RelationManagers;
use App\Models\Payments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ButtonAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TagsColumn;

class PedidosResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Admin';
    protected static ?string $navigationLabel = 'Pedidos';

    public static function canCreate(): bool
    {
        return false; // Retorna false para desabilitar o botão de criar novos registros
    }

    public static function getNavigationBadge(): ?string
    {
        return Payments::count(); // Retorna o número total de registros
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view admin');
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
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->label('Id do Pedido'),


                    Tables\Columns\TextColumn::make('description')
                    ->label('Descrição do Pedido')
                    ->getStateUsing(function ($record) {
                        // Acessar o campo `description` como um array
                        $description = $record->description;
                
                        // Verificar se `description` é realmente um array e contém o campo `info`
                        if (is_array($description) && isset($description['info'])) {
                            $info = $description['info'];
                
                            // Montar uma string formatada com os campos que você precisa
                            return "Tipo: {$info['type']}, Valor: {$info['value']}, User ID: {$info['user_id']}";
                        }
                
                        // Retornar uma string vazia se os dados não forem encontrados
                        return '';
                    })->searchable(),
                    
                    Tables\Columns\TextColumn::make('status')
                    ->label('Status'),
                    ])
            ->filters([
                //
            ])
            ->actions([
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPedidos::route('/'),
        ];
    }
}
