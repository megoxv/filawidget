<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;

class WidgetAreaStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total number of widget areas
        $totalWidgetAreas = WidgetArea::count();

        // Number of active widget areas
        $activeWidgetAreas = WidgetArea::active()->count();

        // Number of inactive widget areas
        $inactiveWidgetAreas = WidgetArea::where('status', false)->count();

        // Number of widgets in all widget areas
        $totalWidgets = Widget::count();

        return [
            Stat::make('Total Widget Areas', $totalWidgetAreas)
                ->description('Total number of widget areas created')
                ->color('primary'),
            Stat::make('Active Widget Areas', $activeWidgetAreas)
                ->description('Number of active widget areas')
                ->color('success'),
            Stat::make('Inactive Widget Areas', $inactiveWidgetAreas)
                ->description('Number of inactive widget areas')
                ->color('danger'),
            Stat::make('Total Widgets', $totalWidgets)
                ->description('Number of widgets in all areas')
                ->color('warning'),
        ];
    }
}
