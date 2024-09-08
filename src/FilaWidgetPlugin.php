<?php

namespace IbrahimBougaoua\Filawidget;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use IbrahimBougaoua\Filawidget\Pages\Appearance;
use IbrahimBougaoua\Filawidget\Resources\PageResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Widgets\WidgetAreaStatsOverview;
use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Widgets\WidgetStatsOverview;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

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
                PageResource::class,
                WidgetResource::class,
                WidgetAreaResource::class,
                WidgetFieldResource::class,
                WidgetTypeResource::class,
            ])
            ->pages([
                Appearance::class,
            ])
            ->widgets([
                WidgetStatsOverview::class,
                WidgetAreaStatsOverview::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        if(config('filawidget.show_home_link'))
        {
            FilamentView::registerRenderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): View => view('filawidget::components.home'),
            );
        }

        if(Route::currentRouteName() === 'filament.admin.pages.appearance')
        {
            FilamentView::registerRenderHook(
                PanelsRenderHook::CONTENT_START,
                fn (): View => view('filawidget::components.filter'),
            );
        }

        if(config('filawidget.show_quick_appearance'))
        {
            FilamentView::registerRenderHook( 
                PanelsRenderHook::TOPBAR_START,
                fn (): View => view('filawidget::components.quick'),
            );
        }
    }
}