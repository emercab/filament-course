<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class UserResource extends Resource
{
  protected static ?string $model = User::class;
  protected static ?string $navigationLabel = 'Employees';
  protected static ?string $navigationGroup = 'Employee Management';
  protected static ?string $navigationIcon = 'fas-users';
  protected static ?int $navigationSort = 2;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Section::make('Personal Information')
          ->description('Please enter your personal information.')
          ->columns(2)
          ->schema([
            Forms\Components\TextInput::make('name')
              ->required(),

            Forms\Components\TextInput::make('email')
              ->email()
              ->required(),

            Forms\Components\TextInput::make('password')
              ->password()
              ->hiddenOn(['edit'])
              ->required(),
          ]),

        Section::make('Address Information')
          ->columns(2)
          ->schema([
            Forms\Components\Select::make('country_id')
              ->relationship('country', 'name')
              ->afterStateUpdated(function (Set $set) {
                $set('state_id', null);
                $set('city_id', null);
              })
              ->searchable()
              ->preload()
              ->live()
              ->required(),

            Forms\Components\Select::make('state_id')
              ->options(fn (Get $get): Collection => State::query()
                ->where('country_id', $get('country_id'))
                ->orderBy('name')
                ->pluck('name', 'id'))
              ->afterStateUpdated(fn (Set $set) => $set('city_id', null))
              ->searchable()
              ->preload()
              ->live()
              ->required(),

            Forms\Components\Select::make('city_id')
              ->options(fn (Get $get): Collection => City::query()
                ->where('state_id', $get('state_id'))
                ->orderBy('name')
                ->pluck('name', 'id'))
              ->searchable()
              ->preload()
              ->live()
              ->required(),

            Forms\Components\TextInput::make('address')
              ->required(),

            Forms\Components\TextInput::make('postal_code')
              ->required(),
          ]),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->searchable(),

        Tables\Columns\TextColumn::make('email')
          ->searchable(),

        Tables\Columns\TextColumn::make('address')
          ->sortable()
          ->searchable()
          ->toggleable(isToggledHiddenByDefault: false),

        Tables\Columns\TextColumn::make('postal_code')
          ->sortable()
          ->searchable()
          ->toggleable(isToggledHiddenByDefault: false),

        Tables\Columns\TextColumn::make('email_verified_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
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
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
