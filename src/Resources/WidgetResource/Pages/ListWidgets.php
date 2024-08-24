<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWidgets extends ListRecords
{
    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
