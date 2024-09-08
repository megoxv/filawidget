<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;

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
