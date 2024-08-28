<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $table = 'widgets';

    protected $fillable = ['name', 'widget_area_id', 'widget_type_id','fieldsIds'];

    protected $casts = [
        'fieldsIds' => 'array', // Automatically cast JSON to an array
    ];

    /**
     * Get the widget area that owns the widget.
     */
    public function area()
    {
        return $this->belongsTo(WidgetArea::class);
    }

    /**
     * Get the widget type that owns the widget.
     */
    public function type()
    {
        return $this->belongsTo(WidgetType::class);
    }
    
    /**
     * Get the fields associated with the widget.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class, 'widget_fields', 'widget_id', 'field_id');
    }
}
