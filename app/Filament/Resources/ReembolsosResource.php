<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReembolsosResource\Pages;
use App\Filament\Resources\ReembolsosResource\RelationManagers;
use App\Models\Reembolso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;

class ReembolsosResource extends Resource
{
    protected static ?string $model = Reembolso::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Gestão';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view gestao');
    }

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name') // Usando a relação com `User` para selecionar pelo nome
                ->label('Usuário')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->label('Descrição')
                ->placeholder('A info id {id da info} foi solicitada o reembolso, após uma analise vemos a info estava {problema da info}')
                ->required(),

            Forms\Components\TextInput::make('chave_pix')
                ->label('Chave PIX')
                ->placeholder('Especifique a chave e o tipo da chave')
                ->required(),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            TextColumn::make('user.name')
                ->label('Usuário')
                ->sortable()
                ->searchable(),

            TextColumn::make('description')
                ->label('Descrição')
                ->limit(50)
                ->tooltip(fn ($record) => $record->description),

            TextColumn::make('status')
                ->label('Status')
                ->sortable()
                ->searchable(),

            TextColumn::make('chave_pix')
                ->label('Chave PIX')
                ->sortable()
                ->searchable(),
        ])
        ->filters([
            // Você pode adicionar filtros para status ou usuários específicos, por exemplo
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'pendente' => 'Pendente',
                    'aprovado' => 'Aprovado',
                    'recusado' => 'Recusado',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReembolsos::route('/'),
            'create' => Pages\CreateReembolsos::route('/create'),
            'edit' => Pages\EditReembolsos::route('/{record}/edit'),
        ];
    }
}
