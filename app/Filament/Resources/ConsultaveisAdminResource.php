<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConsultaveisAdminResource\Pages;
use App\Filament\Resources\ConsultaveisAdminResource\RelationManagers;
use App\Models\Infos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConsultaveisAdminResource extends Resource
{
    protected static ?string $model = Infos::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Gestão';

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view gestao');
    }

    public static function getNavigationBadge(): ?string
    {
        return Infos::where('is_published', false)->count(); // Retorna o número total de registros
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Wizard::make()
                ->steps([
                    Forms\Components\Wizard\Step::make('Informações do Cartão')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('ccn')
                                        ->required()
                                        ->mask('9999999999999999')
                                        ->label('Número Do Cartão'),
                                    Forms\Components\TextInput::make('validade')
                                        ->mask('99 / 99')
                                        ->placeholder('MM/YY')    
                                        ->required()
                                        ->label('Validade'),
                                    Forms\Components\TextInput::make('cvv')
                                        ->required()
                                        ->label('CVV'),
                                    Forms\Components\TextInput::make('senha6')
                                        ->required()
                                        ->label('Senha De 6')
                                        ->nullable(),
                                    Forms\Components\TextInput::make('nome')
                                        ->required()
                                        ->label('Nome'),
                                        Forms\Components\Select::make('genero')
                                        ->options([
                                            'masculino' => 'Masculino',
                                            'feminino' => 'Feminino',
                                        ])
                                        ->nullable()
                                        ->native(false)
                                ]),
                        ]),
                    Forms\Components\Wizard\Step::make('Informações Do Bico')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('email')
                                        ->email()
                                        ->nullable()
                                        ->label('Email'),
                                    Forms\Components\TextInput::make('telefone')
                                        ->tel()
                                        ->nullable()
                                        ->label('Telefone'),
                                    Forms\Components\TextInput::make('cpf')
                                        ->mask('999.999.999-99')
                                        ->nullable()
                                        ->label('CPF'),
                                    Forms\Components\FileUpload::make('info')
                                        ->directory('PUXADAS')
                                        ->label('Puxada')
                                        ->visibility('private')
                                        ->acceptedFileTypes(['text/plain'])
                                ]),
                        ]),
                    Forms\Components\Wizard\Step::make('Informações de Venda')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('limite')
                                        ->required()
                                        ->label('Limite Da Info')
                                        ->postfix('BRL')
                                        ->prefix('R$'),
                                    Forms\Components\TextInput::make('valor')
                                        ->required()
                                        ->label('Valor De Venda Da Info')
                                        ->postfix('BRL')
                                        ->prefix('R$'),
                                    Forms\Components\Select::make('categoria')
                                    ->options([
                                        'full' => 'Full',
                                        'consultavel' => 'Consultavel',
                                        'consultada' => 'Consultada',
                                    ])
                                    ->required()
                                    ->native(false),  
                                    Forms\Components\Select::make('is_published')
                                    ->options([
                                        1 => 'Publicada', 
                                        0 => 'Não Publicada',
                                    ])
                                    ->label('Status Da Info')
                                    ->required()
                                    ->native(false),    
                                ]),
                        ]),
                ]),
        ])
        ->defaultSort('created_at', 'desc');    
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ccn')
                    ->label('BIN')
                    ->limit(6, ''),
                Tables\Columns\TextColumn::make('banco')
                    ->label('BANCO')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_published')
                    ->label('Publicada')
                    ->searchable(),
                Tables\Columns\TextColumn::make('limite')
                    ->label('Limite')
                    ->sortable()
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('categoria')
                    ->label('Categoria')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valor')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListConsultaveisAdmins::route('/'),
            'create' => Pages\CreateConsultaveisAdmin::route('/create'),
            'view' => Pages\ViewConsultaveisAdmin::route('/{record}'),
            'edit' => Pages\EditConsultaveisAdmin::route('/{record}/edit'),
        ];
    }
}
