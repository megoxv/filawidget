<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetType extends Model
{
    protected $table = 'widget_types';

    protected $fillable = ['name', 'config', 'fieldsIds', 'order'];

    protected $casts = [
        'config' => 'array', // Automatically cast the JSON to an array
        'fieldsIds' => 'array', // Automatically cast JSON to an array
    ];

    /**
     * Accessor to get the fields associated with this widget type.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class, 'widget_type_fields', 'widget_type_id', 'field_id');
    }
}
