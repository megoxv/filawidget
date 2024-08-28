<?php

namespace IbrahimBougaoua\Filawidget\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetArea extends Model
{
    // Define the table name if different from the class name in plural
    protected $table = 'widget_areas';

    // Specify fillable fields to allow mass assignment
    protected $fillable = ['name', 'identifier'];

    /**
     * Get the widgets associated with the widget area.
     */
    public function widgets()
    {
        return $this->hasMany(Widget::class);
    }
}