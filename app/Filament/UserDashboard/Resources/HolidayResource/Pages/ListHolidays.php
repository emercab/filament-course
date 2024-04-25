<?php

namespace App\Filament\UserDashboard\Resources\HolidayResource\Pages;

use App\Filament\UserDashboard\Resources\HolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
