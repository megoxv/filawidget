<?php

namespace IbrahimBougaoua\Filawidget\Pages;

use Filament\Pages\Page;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use Illuminate\View\View;

class Appearance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filawidget::pages.appearance';

    public $widgetsOrder = [];
    public $widgetAreasOrder = [];
    public $widgets = [];
    public $widgetAreas = [];
    public $nbrWidgetAreas = 0;

    public static function getNavigationGroup(): ?string
    {
        return 'Appearance';
    }

    public function mount()
    {
        // Get ordered widgets from the database
        $this->widgets = Widget::ordered()->get();
        $this->widgetAreas = WidgetArea::ordered()->withOrderedWidgets()->get();
        $this->nbrWidgetAreas = $this->widgetAreas ? count($this->widgetAreas) : 0;
    }

    public function updateOrder()
    {
        // Validate the input to ensure it's an array
        if (!is_array($this->widgetsOrder) || !is_array($this->widgetAreasOrder)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input.'], 400);
        }

        // Update widget order in the database
        foreach ($this->widgetAreasOrder as $index => $widgetAreaId) {
            WidgetArea::where('id', $widgetAreaId)->update(['order' => $index + 1]);
        }

        foreach ($this->widgetsOrder as $index => $widgetId) {
            Widget::where('id', $widgetId)->update(['order' => $index + 1]);
        }

        // Refresh the widgets list after updating
        //$this->widgets = Widget::ordered()->get();
        $this->widgetAreas = WidgetArea::ordered()->withOrderedWidgets()->get();

        if($this->widgetAreasOrder != [])
            session()->flash('areaStatus', 'Area order successfully updated.');

        if($this->widgetsOrder != [])
            session()->flash('widgetStatus', 'Widgets order successfully updated.');
    }
    
    public function hideAlert()
    {
        session()->flash('status', null);
    }

    public function getHeader(): ?View
    {
        return view('filawidget::components.header');
    }
}
