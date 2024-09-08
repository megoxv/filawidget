<?php

namespace IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use IbrahimBougaoua\Filawidget\Models\WidgetField;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource;

class EditWidget extends EditRecord
{
    protected static string $resource = WidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Get the record ID
        $widgetId = $this->record->id;

        // Retrieve form state
        $data = $this->form->getState();

        // Delete existing WidgetFields for this widget to avoid duplicates
        WidgetField::where('widget_id', $widgetId)->delete();

        // Check if there are any repeater values
        if (isset($data['values']) && is_array($data['values'])) {
            foreach ($data['values'] as $fieldData) {
                // Iterate through each field in the repeater
                foreach ($fieldData as $fieldName => $value) {
                    // Ensure the field exists in the repeater and find its corresponding field ID
                    if ($fieldName) {
                        //dd($fieldName);
                        // Find the correct field ID based on the name or position
                        $fieldIdIndex = array_search($fieldName, array_keys($fieldData));
                        $fieldId = $this->record->fieldsIds[$fieldIdIndex] ?? null;
                        //dd('widget_id = ' . $widgetId,' widget_field_id = ' . $fieldId . ' value = ' . $value, );
                        if ($fieldId) {
                            // Save each field value
                            WidgetField::create([
                                'widget_id' => $widgetId,
                                'widget_field_id' => $fieldId, // Use the correct field ID
                                'value' => $value, // Save the actual value from the repeater
                            ]);
                        }
                    }
                }
            }
        }
    }
}
