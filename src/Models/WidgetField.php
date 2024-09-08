<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetField extends Model
{
    public $incrementing = false;

    protected $primaryKey = ['widget_id', 'widget_field_id'];
    
    public $timestamps = false;

    protected $fillable = [
        'value',
        'widget_id',
        'widget_field_id',
    ];

    protected $casts = [
        'value' => 'array',
    ];
}
