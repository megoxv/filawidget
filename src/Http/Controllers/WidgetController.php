<?php

namespace IbrahimBougaoua\Filawidget\Http\Controllers;

use App\Http\Controllers\Controller;
use IbrahimBougaoua\Filawidget\Models\Widget;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * Update the order of the widgets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrder(Request $request)
    {
        $order = $request->input('order');

        // Validate the input to ensure it's an array
        if (! is_array($order)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid input.'], 400);
        }

        // Update widget order in the database
        foreach ($order as $index => $widgetId) {
            Widget::where('id', $widgetId)->update(['order' => $index + 1]);
        }

        return response()->json(['status' => 'success']);
    }
}
