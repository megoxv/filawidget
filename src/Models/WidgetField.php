<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetField extends Model
{
    protected $fillable = [
        'widget_id',
        'field_id',
    ];
}
