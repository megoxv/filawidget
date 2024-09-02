<?php

namespace IbrahimBougaoua\Filawidget\Services;

use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use Illuminate\Database\Eloquent\Collection;

class AreaService
{
    public static function getAllAreas(): ?Collection
    {
        return WidgetArea::active()->with('widgets')->get();
    }

    public static function getWidgetByIdentifier(string $identifier): ?WidgetArea
    {
        return WidgetArea::active()->where('identifier',$identifier)->first();
    }
}