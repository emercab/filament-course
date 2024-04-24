<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class UsersChart extends ChartWidget
{
  protected static ?string $heading = 'Chart';

  protected function getData(): array
  {
    return [
      'datasets' => [
        [
          'label' => 'Users',
          'data' => $this->getUsersData(),
        ],
      ],
      'labels' => ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr',],
    ];
  }

  protected function getType(): string
  {
    return 'bar';
  }

  private function getUsersData(): array
  {
    return [
      65, 59, 70, 81, 46, 55,
    ];
  }
}
