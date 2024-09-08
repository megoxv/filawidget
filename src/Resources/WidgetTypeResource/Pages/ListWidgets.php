<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWidgets extends ListRecords
{
    protected static string $resource = WidgetTypeResource::class;

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
}
