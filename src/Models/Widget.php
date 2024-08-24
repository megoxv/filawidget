<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $fillable = ['widget_type_id', 'widget_area_id', 'config', 'order'];

    protected $casts = [
        'config' => 'array',
    ];

    public function type()
    {
        return $this->belongsTo(WidgetType::class);
    }

    public function area()
    {
        return $this->belongsTo(WidgetArea::class);
    }
}
