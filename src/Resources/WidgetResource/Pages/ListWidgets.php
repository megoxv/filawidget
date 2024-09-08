<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Widgets\WidgetStatsOverview;

class ListWidgets extends ListRecords
{
    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('appearance')
                ->url(route('filament.admin.pages.appearance'))
                ->icon('heroicon-o-paint-brush')
                ->color('success')
                ->label(__('filawidget::filawidget.Appearance')),
            Actions\CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WidgetStatsOverview::class,
        ];
    }
}
