<?php

namespace IbrahimBougaoua\Filawidget\Services;

use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use IbrahimBougaoua\Filawidget\Models\WidgetType;

class WidgetService
{
    /**
     * Get all widget configurations for a specific area.
     *
     * @param string $areaIdentifier
     * @return \Illuminate\Support\Collection
     */
    public function getWidgetConfigsByArea($areaIdentifier)
    {
        $area = WidgetArea::where('identifier', $areaIdentifier)->first();

        if (!$area) {
            return collect(); // Return an empty collection if area not found
        }

        return $area->widgets()->orderBy('order')->get()->map(function ($widget) {
            return [
                'type' => $widget->type, // Include widget type
                'config' => $widget->config, // Include widget configuration
            ];
        });
    }

    /**
     * Get a specific widget configuration by widget ID.
     *
     * @param int $widgetId
     * @return array|null
     */
    public function getWidgetConfigById($widgetId)
    {
        $widget = Widget::find($widgetId);

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return [
            'type' => $widget->type, // Include widget type
            'config' => $widget->config, // Include widget configuration
        ];
    }

    /**
     * Get a specific widget configuration by widget name.
     *
     * @param string $name
     * @return array|null
     */
    public function getWidgetConfigByName($name)
    {
        $widget = Widget::where('name', $name)->first();

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return [
            'type' => $widget->type, // Include widget type
            'config' => $widget->config, // Include widget configuration
        ];
    }

    /**
     * Get a specific configuration value from a widget by widget ID.
     *
     * @param int $widgetId
     * @param string $key
     * @return mixed
     */
    public function getWidgetConfigValueById($widgetId, $key)
    {
        $widget = Widget::find($widgetId);

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return $widget->config[$key] ?? null;
    }

    /**
     * Get a specific configuration value from a widget by widget name.
     *
     * @param string $name
     * @param string $key
     * @return mixed
     */
    public function getWidgetConfigValueByName($name, $key)
    {
        $widget = Widget::where('name', $name)->first();

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return $widget->config[$key] ?? null;
    }

    /**
     * Get the widget type by widget ID.
     *
     * @param int $widgetId
     * @return WidgetType|null
     */
    public function getWidgetTypeById($widgetId)
    {
        $widget = Widget::find($widgetId);

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return $widget->type; // Return the widget's type
    }

    /**
     * Get the widget type by widget name.
     *
     * @param string $name
     * @return WidgetType|null
     */
    public function getWidgetTypeByName($name)
    {
        $widget = Widget::where('name', $name)->first();

        if (!$widget) {
            return null; // Return null if widget not found
        }

        return $widget->type; // Return the widget's type
    }
}
