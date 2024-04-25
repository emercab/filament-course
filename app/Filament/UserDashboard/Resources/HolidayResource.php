<?php

namespace App\Filament\UserDashboard\Resources;

use App\Filament\UserDashboard\Resources\HolidayResource\Pages;
use App\Filament\UserDashboard\Resources\HolidayResource\RelationManagers;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayResource extends Resource
{
  protected static ?string $model = Holiday::class;
  protected static ?string $navigationIcon = 'far-calendar-days';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('calendar_id')
          ->relationship(name: 'calendar', titleAttribute: 'name')
          ->required(),

        Forms\Components\DatePicker::make('day')
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('calendar.name')
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('user.name')
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('day')
          ->date()
          ->sortable(),

        Tables\Columns\TextColumn::make('type')
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'approved' => 'success',
            'pending' => 'warning',
            'declined' => 'danger',
          })
          ->searchable(),

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
        SelectFilter::make('type')
          ->options([
            'declined' => 'Declined',
            'approved' => 'Approved',
            'pending' => 'Pending',
          ])
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
      'index' => Pages\ListHolidays::route('/'),
      'create' => Pages\CreateHoliday::route('/create'),
      'edit' => Pages\EditHoliday::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->where('user_id', auth()->id());
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
