<?php

namespace App\Filament\UserDashboard\Resources\TimesheetResource\Pages;

use App\Filament\UserDashboard\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
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
        ->action('start_work'),

      Action::make('stop_work')
        ->label('Stop Work')
        ->icon('far-circle-stop')
        ->color('danger')
        ->requiresConfirmation()
        ->action('stop_work'),

      Action::make('start_pause')
        ->label('Start Pause')
        ->icon('far-calendar-minus')
        ->color('warning')
        ->requiresConfirmation()
        ->action('start_pause'),

        Action::make('stop_pause')
        ->label('Stop Pause')
        ->icon('far-circle-stop')
        ->color('danger')
        ->requiresConfirmation()
        ->action('stop_pause'),

      Actions\CreateAction::make()
        ->icon('far-square-plus')
        ->color('info'),

    ];
  }

  public function start_work(): void
  {
    // Create a new timesheet record
    $user = auth()->user();
    $timesheet = Timesheet::create([
      'user_id' => $user->id,
      'calendar_id' => 1,
      'type' => 'work',
      'day_in' => Carbon::now(),
      'day_out' => null,
    ]);
  }

  public function start_pause(): void
  {
    // Get the last timesheet record for the current user
    $lastTimesheet = $this->getLastTimesheet();

    // Update the last timesheet record
    $lastTimesheet->update([
      'day_out' => Carbon::now(),
    ]);

    // Create a new timesheet record
    $timesheet = Timesheet::create([
      'user_id' => auth()->user()->id,
      'calendar_id' => 1,
      'type' => 'pause',
      'day_in' => Carbon::now(),
      'day_out' => null,
    ]);
  }

  public function stop_work(): void
  {
    // Get the last timesheet record for the current user
    $lastTimesheet = $this->getLastTimesheet();

    // Update the last timesheet record
    $lastTimesheet->update([
      'day_out' => Carbon::now(),
    ]);
  }

  public function stop_pause(): void
  {
    // Get the last timesheet record for the current user
    $lastTimesheet = $this->getLastTimesheet();

    // Update the last timesheet record
    $lastTimesheet->update([
      'day_out' => Carbon::now(),
    ]);
  }

  private function getLastTimesheet(): Timesheet
  {
    $user = auth()->user();
    return Timesheet::where('user_id', $user->id)
      ->orderBy('id', 'desc')
      ->first();
  }
}
