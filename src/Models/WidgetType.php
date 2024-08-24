<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetType extends Model
{
    protected $fillable = [
        'name',
        'class',
    ];

    public function widgets()
    {
        return $this->hasMany(Widget::class, 'widget_type_id');
    }

    public function fields()
    {
        return $this->hasMany(WidgetField::class, 'widget_type_id');
    }
}