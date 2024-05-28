<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Admin';

    public static function getNavigationBadge(): ?string
    {
        return User::count(); // Retorna o número total de registros
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view admin');
    }

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('name')
            ->required()
            ->label('Name'),
        Forms\Components\TextInput::make('email')
            ->email()
            ->required()
            ->label('Email'),
        Forms\Components\TextInput::make('password')
            ->password()
            ->required()
            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
            ->label('Password'),
            Select::make('role')
            ->label('Role')
            ->options(Role::all()->pluck('name', 'name'))
            ->reactive()
            ->afterStateUpdated(function ($state, $record) {
                if ($record) {
                    $record->syncRoles($state);
                }
            })
            ->default(function ($get) {
                return $get('record')?->getRoleNames()->first(); // Pega a primeira role do usuário
            }),
    ]);
}
public static function table(Table $table): Table
{
    return $table->columns([
        Tables\Columns\TextColumn::make('name')
            ->label('Name'),

        Tables\Columns\TextColumn::make('email')
            ->label('Email'),

        // Adicionando uma coluna para as roles do usuário
        TextColumn::make('roles.name')
           ->label('Role')
           ->getStateUsing(fn ($record) => $record->roles->first()?->name ?? 'N/A'),

    ])->filters([
        // Seus filtros podem ser adicionados aqui
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
