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
        $totalWidgetAreas = WidgetArea::count();

        $activeWidgetAreas = WidgetArea::active()->count();

        $inactiveWidgetAreas = WidgetArea::where('status', false)->count();

        $totalWidgets = Widget::count();
        
        return [
            Stat::make(__('filawidget::filawidget.Total Widget Areas'), $totalWidgetAreas)
                ->description(__('filawidget::filawidget.WidgTotal number of widget areas createdet Area'))
                ->color('primary'),
            Stat::make(__('filawidget::filawidget.Active Widget Areas'), $activeWidgetAreas)
                ->description(__('filawidget::filawidget.Number of active widget areas'))
                ->color('success'),
            Stat::make(__('filawidget::filawidget.Inactive Widget Areas'), $inactiveWidgetAreas)
                ->description(__('filawidget::filawidget.Number of inactive widget areas'))
                ->color('danger'),
            Stat::make(__('filawidget::filawidget.Total Widgets'), $totalWidgets)
                ->description(__('filawidget::filawidget.Number of widgets in all areas'))
                ->color('warning'),
        ];
    }
}
