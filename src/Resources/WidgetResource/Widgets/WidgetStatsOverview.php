<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use IbrahimBougaoua\Filawidget\Models\Widget;

class WidgetStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Example statistics calculations for Widget model

        // Total number of widgets
        $totalWidgets = Widget::count();

        // Number of active widgets
        $activeWidgets = Widget::active()->count();

        // Number of inactive widgets
        $inactiveWidgets = Widget::active()->count();

        // Number of widgets per type (assuming you have a type relationship or type field)
        $widgetTypeStats = Widget::select('widget_type_id')
            ->selectRaw('count(*) as count')
            ->groupBy('widget_type_id')
            ->get();

        return [
            Stat::make('Total Widgets', $totalWidgets)
                ->description('Total number of widgets created')
                ->color('primary'),
            Stat::make('Active Widgets', $activeWidgets)
                ->description('Number of active widgets')
                ->color('success'),
            Stat::make('Inactive Widgets', $inactiveWidgets)
                ->description('Number of inactive widgets')
                ->color('danger'),
            Stat::make('Widgets Per Type', $widgetTypeStats->pluck('count')->sum())
                ->description('Number of widgets by type')
                ->color('warning'),
        ];
    }
}
