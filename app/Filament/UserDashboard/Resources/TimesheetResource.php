<?php

namespace App\Filament\UserDashboard\Resources;

use App\Filament\UserDashboard\Resources\TimesheetResource\Pages;
use App\Filament\UserDashboard\Resources\TimesheetResource\RelationManagers;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimesheetResource extends Resource
{
  protected static ?string $model = Timesheet::class;
  protected static ?string $navigationIcon = 'fas-clock';

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('calendar_id')
          ->relationship(name: 'calendar', titleAttribute: 'name')
          ->required(),

        Forms\Components\Select::make('type')
          ->options([
            'work' => 'Working',
            'pause' => 'In Pause',
          ]),

        Forms\Components\DateTimePicker::make('day_in')
          ->required(),

        Forms\Components\DateTimePicker::make('day_out')
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('calendar.name')
          ->sortable()
          ->searchable(),

        Tables\Columns\TextColumn::make('user.name')
          ->sortable()
          ->searchable(),

        Tables\Columns\TextColumn::make('type')
          ->badge()
          ->color(fn (string $state): string => match ($state) {
            'work' => 'success',
            'pause' => 'warning',
          })
          ->searchable(),

        Tables\Columns\TextColumn::make('day_in')
          ->dateTime('d/M/y - h:i a')
          ->sortable()
          ->searchable(),

        Tables\Columns\TextColumn::make('day_out')
          ->dateTime('d/M/y - h:i a')
          ->sortable()
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
            'work' => 'Working',
            'pause' => 'In Pause',
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
      'index' => Pages\ListTimesheets::route('/'),
      'create' => Pages\CreateTimesheet::route('/create'),
      'edit' => Pages\EditTimesheet::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()->where('user_id', auth()->id());
  }
}
