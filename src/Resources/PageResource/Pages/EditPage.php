<?php

namespace IbrahimBougaoua\Filawidget\Resources\PageResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
