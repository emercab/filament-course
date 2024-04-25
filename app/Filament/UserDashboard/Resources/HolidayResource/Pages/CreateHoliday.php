<?php

namespace App\Filament\UserDashboard\Resources\HolidayResource\Pages;

use App\Filament\UserDashboard\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHoliday extends CreateRecord
{
  protected static string $resource = HolidayResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    // Set default values for the holiday resource
    $data['user_id'] = auth()->id();
    $data['type'] = 'pending';
    
    return $data;
  }
}
