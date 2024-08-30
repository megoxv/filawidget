<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Widgets\WidgetAreaStatsOverview;

class ListWidgetAreas extends ListRecords
{
    protected static string $resource = WidgetAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('appearance')
                ->url(route('filament.admin.pages.appearance'))
                ->icon('heroicon-o-paint-brush')
                ->color('success')
                ->label('Appearance'),
            Actions\CreateAction::make()->icon('heroicon-o-plus'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WidgetAreaStatsOverview::class,
        ];
    }
}
