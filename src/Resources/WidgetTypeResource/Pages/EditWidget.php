<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;

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
