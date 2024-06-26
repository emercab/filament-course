<?php

namespace App\Filament\UserDashboard\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserPanelStats extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('Pending Holidays', $this->getHolidays('pending')),
      Stat::make('Approved Holidays', $this->getHolidays('approved')),
      Stat::make('Total Work', $this->getTotalTime('work')),
      Stat::make('Total Pause', $this->getTotalTime('pause')),
    ];
  }

  private function getHolidays(string $type)
  {
    return Holiday::where('type', $type)
      ->where('user_id', auth()->id())
      ->count();
  }

  private function getTotalTime(string $type): string
  {
    $timesheets = Timesheet::where('user_id', auth()->id())
      ->where('type', $type)
      ->get();

    // Iterate over each timesheet and calculate the total work
    $total_work = 0;
    foreach ($timesheets as $timesheet) {
      $day_out = Carbon::parse($timesheet->day_out);
      $day_in = Carbon::parse($timesheet->day_in);

      $work_seconds = $day_out->diffInSeconds($day_in);
      $total_work += $work_seconds;
    }

    // Convert the total work to hours and minutes
    $hours = floor($total_work / 3600);
    $minutes = floor($total_work / 60) - ($hours * 60);
    $seconds = $total_work - ($minutes * 60) - ($hours * 3600);

    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
  }
}
