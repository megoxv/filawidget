<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetArea extends Model
{
    protected $fillable = [
        'name',
        'identifier',
    ];

    public function widgets()
    {
        return $this->hasMany(Widget::class);
    }
}