<?php

namespace IbrahimBougaoua\Filawidget;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use IbrahimBougaoua\Filawidget\Pages\Appearance;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;
use Illuminate\View\View;

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
                Appearance::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            fn (): View => view('filawidget::components.home'),
        );

        FilamentView::registerRenderHook( 
            PanelsRenderHook::TOPBAR_START,
            fn (): View => view('filawidget::components.quick'),
        );
    }
}