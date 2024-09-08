<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;

class ListWidgetTypes extends ListRecords
{
    protected static string $resource = WidgetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
