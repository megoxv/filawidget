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
            Actions\CreateAction::make(),
        ];
    }
}
