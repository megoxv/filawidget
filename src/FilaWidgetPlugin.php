<?php

namespace IbrahimBougaoua\Filawidget;

use Filament\Contracts\Plugin;
use Filament\Panel;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;

class FilaWidgetPlugin implements Plugin
{
    public function getId(): string
    {
        return 'fila-widget';
    }
 
    public static function make(): static
    {
        return app(static::class);
    }
    
    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                WidgetResource::class,
                WidgetAreaResource::class,
                WidgetFieldResource::class,
                WidgetTypeResource::class,
            ])
            ->pages([

            ]);
    }
 
    public function boot(Panel $panel): void
    {
        //
    }
}