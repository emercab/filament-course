<?php

namespace App\Filament\UserDashboard\Resources\TimesheetResource\Pages;

use App\Filament\UserDashboard\Resources\TimesheetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTimesheet extends CreateRecord
{
  protected static string $resource = TimesheetResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // Set default values for the holiday resource
    $data['user_id'] = auth()->id();

    return $data;
  }
}
