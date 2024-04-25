<?php

namespace App\Filament\UserDashboard\Resources\TimesheetResource\Pages;

use App\Filament\UserDashboard\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTimesheets extends ListRecords
{
  protected static string $resource = TimesheetResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Action::make('start_work')
        ->label('Enter Work')
        ->icon('far-calendar-plus')
        ->color('success')
        ->requiresConfirmation()
        ->action($this->start_work()),

      Action::make('start_pause')
        ->label('Start Pause')
        ->icon('far-calendar-minus')
        ->color('danger')
        ->requiresConfirmation(),

      Actions\CreateAction::make()
        ->icon('far-square-plus'),

    ];
  }

  private function start_work()
  {
    return 0;
  }
}
