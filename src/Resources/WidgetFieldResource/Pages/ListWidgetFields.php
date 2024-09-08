<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource\Pages;

use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWidgetFields extends ListRecords
{
    protected static string $resource = WidgetFieldResource::class;

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
