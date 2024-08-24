<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWidgetAreas extends ListRecords
{
    protected static string $resource = WidgetAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
