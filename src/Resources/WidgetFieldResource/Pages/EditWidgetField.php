<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWidgetField extends EditRecord
{
    protected static string $resource = WidgetFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
