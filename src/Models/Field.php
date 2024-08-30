<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{    
    protected $table = 'fields';

    protected $fillable = ['name', 'type', 'options'];

    protected $casts = [
        'options' => 'array', // Automatically cast the JSON to an array
    ];

    /**
     * Get the widget types that use this field.
     */
    public function types()
    {
        return $this->belongsToMany(WidgetType::class, 'widget_type_fields', 'field_id', 'widget_type_id');
    }

    /**
     * Get the widgets that use this field.
     */
    public function widgets()
    {
        return $this->belongsToMany(Widget::class, 'widget_fields', 'widget_field_id', 'widget_id');
    }
}
