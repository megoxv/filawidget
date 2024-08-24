<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetField extends Model
{
    protected $fillable = [
        'widget_type_id',
        'name',
        'type',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function widgetType()
    {
        return $this->belongsTo(WidgetType::class, 'widget_type_id');
    }
}