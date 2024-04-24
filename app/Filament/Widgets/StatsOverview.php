<?php

namespace App\Filament\Widgets;

use App\Models\Calendar;
use App\Models\Timesheet;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $totalEmployees = User::all()->count();
    $totalCalendars = Calendar::all()->count();
    $totalTimesheets = Timesheet::all()->count();
    return [
      Stat::make('Employees', $totalEmployees)
        ->description('3% increase')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->extraAttributes([
          'class' => 'bg-orange-500',
        ])
        ->color('success'),

      Stat::make('Calendars', $totalCalendars),

      Stat::make('Timesheets', $totalTimesheets),
    ];
  }
}
