<?php

namespace IbrahimBougaoua\Filawidget\Observers;

use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\WidgetType;
use Illuminate\Support\Str;

class WidgetTypeObserver
{
    public function creating(WidgetType $widgetType)
    {
        $widgetType->slug = Str::slug($widgetType->name, '-');
    }

    public function updated(WidgetType $widgetType): void
    {
        Widget::where('widget_type_id', $widgetType->id)->update([
            'fieldsIds' => $widgetType->fieldsIds,
        ]);
    }
}
