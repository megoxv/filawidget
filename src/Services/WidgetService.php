<?php

namespace IbrahimBougaoua\Filawidget\Services;

use IbrahimBougaoua\Filawidget\Models\Widget;

class WidgetService
{
    public static function getWidgetBySlug(string $slug): ?Widget
    {
        return Widget::with(['type','area'])->where('slug',$slug)->first();
    }
}
