<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReembolsosAdminResource\Pages;
use App\Filament\Resources\ReembolsosAdminResource\RelationManagers;
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
use Filament\Tables\Actions\ButtonAction;


class ReembolsosAdminResource extends Resource
{
    protected static ?string $model = Reembolso::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Admin';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view admin');
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
        ->query($query)
        ->filters([
            // Você pode adicionar filtros para status ou usuários específicos, por exemplo
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'pendente' => 'Pendente',
                ]),
        ])
        ->actions([
            ButtonAction::make('Reembolsar')
            ->label('Reembolsar')
            ->action(function ($record) {
                // Este callback só será chamado após o usuário confirmar no modal
                return redirect()->route('refund.accept', [
                    'id' => $record->id, 
                ]);
            })
            ->color('danger')
            ->requiresConfirmation() // Solicita confirmação antes de executar a ação
            ->modalHeading('Confirmar Reembolso')
            ->modalSubheading('Você tem certeza que deseja realizar este reembolso?'),
           
            ButtonAction::make('cancelar')
            ->label('Recusar')
            ->action(function ($record) {
                return redirect()->route('refund.decline', [
                    'id' => $record->id, 
                ]);
            })
            ->color('warning')
            ->requiresConfirmation() // Solicita confirmação antes de executar a ação
            ->modalHeading('Confirmar Cancelamente')
            ->modalSubheading('Você tem certeza que deseja cancelar essa requisição?'),

            ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

    protected static function getQuery()
    {
        return Reembolso::where('status', 'pendente');
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
            'index' => Pages\ListReembolsosAdmins::route('/'),
        ];
    }
}
