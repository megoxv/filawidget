<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetField extends Model
{
    // Disable auto-incrementing primary key
    public $incrementing = false;

    // If you use a composite key, specify the primary keys array
    protected $primaryKey = ['widget_id', 'widget_field_id'];
    
    // Disable timestamps if not needed
    public $timestamps = false;

    protected $fillable = [
        'value',
        'widget_id',
        'widget_field_id',
    ];

    protected $casts = [
        'value' => 'array', // Automatically cast JSON to an array
    ];
}
