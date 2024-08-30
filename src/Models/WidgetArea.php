<?php

namespace IbrahimBougaoua\Filawidget\Models;

use IbrahimBougaoua\Filawidget\Observers\WidgetAreaObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([WidgetAreaObserver::class])]
class WidgetArea extends Model
{
    // Define the table name if different from the class name in plural
    protected $table = 'widget_areas';

    // Specify fillable fields to allow mass assignment
    protected $fillable = ['name', 'identifier','order'];

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
     * Get the widgets associated with the widget area.
     */
    public function widgets()
    {
        return $this->hasMany(Widget::class);
    }
    
    public function scopeWithOrderedWidgets($query)
    {
        return $query->with(['widgets' => function ($query) {
            $query->orderBy('order');
        }]);
    }
}