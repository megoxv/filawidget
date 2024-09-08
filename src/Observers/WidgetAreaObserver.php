<?php

namespace IbrahimBougaoua\Filawidget\Observers;

use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use Illuminate\Support\Str;

class WidgetAreaObserver
{
    public function creating(WidgetArea $widgetArea)
    {
        $widgetArea->identifier = Str::slug($widgetArea->name, '-');
    }
}
