<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWidget extends EditRecord
{
    protected static string $resource = WidgetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
