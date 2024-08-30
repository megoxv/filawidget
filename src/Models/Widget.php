<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class Widget extends Model
{
    protected $table = 'widgets';

    protected $fillable = ['name','slug','order','fieldsIds', 'widget_area_id', 'widget_type_id'];

    protected $casts = [
        'fieldsIds' => 'array', // Automatically cast JSON to an array
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public static function updateOrder(array $order)
    {
        foreach ($order as $index => $id) {
            self::where('id', $id)->update(['order' => $index + 1]);
        }
    }
    
    /**
     * Get the widget area that owns the widget.
     */
    public function area()
    {
        return $this->belongsTo(WidgetArea::class,'widget_area_id');
    }

    /**
     * Get the widget type that owns the widget.
     */
    public function type()
    {
        return $this->belongsTo(WidgetType::class,'widget_type_id');
    }

    public function values()
    {
        return $this->hasMany(WidgetField::class);
    }
    
    /**
     * Get the fields associated with the widget.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class, 'widget_fields', 'widget_id', 'field_id');
    }
}
