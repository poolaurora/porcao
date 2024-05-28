<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Tables\Actions\ButtonAction;


class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    protected static ?string $navigationGroup = 'Inventario';

    public static function canCreate(): bool
    {
        return false; // Retorna false para desabilitar o botão de criar novos registros
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome'),
                TextColumn::make('itemable.limite')
                ->label('Limite')
                ->sortable()
                ->money('BRL'),
                TextColumn::make('itemable.genero')
                ->label('Genero'),
                TextColumn::make('created_at')->dateTime('d/m/Y H:i:s')->label('Adquirido em'),
            ])
            ->filters([
            ])
            ->actions([
                ButtonAction::make('view')
                    ->label('Ver Informações')
                    ->action(function ($record) {
                        // Este callback só será chamado após o usuário confirmar no modal
                        return redirect()->route('view.info', [
                            'id' => $record->user->id, 
                            'type' => 'consultavel',
                            'itemId' => $record->id
                        ]);
                    }),

                    ButtonAction::make('redirect')
                    ->label('Pedir Troca')
                    ->color('info')
                    ->action(function ($record) {
                        return redirect("https://wa.me/5531947128422?text=Ol%C3%A1+quero+efetuar+a+troca+da+info+de+id%3A+".$record->itemable->id."");
                    })->visible(function ($record) {
                        // Verificar se o `created_at` está dentro dos últimos 15 minutos
                        return $record->created_at->diffInMinutes(now()) < 15;
                    }),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
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
            'index' => Pages\ListItems::route('/')
        ];
    }
}
