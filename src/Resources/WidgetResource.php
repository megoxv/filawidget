<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\Field as WidgetsField;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use IbrahimBougaoua\Filawidget\Models\WidgetField;
use IbrahimBougaoua\Filawidget\Models\WidgetType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        // Hide this resource from the navigation
        return auth()->user()->isAdmin();
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Appearance';
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('widget_area_id')
                        ->label('Area')
                        ->options(
                            WidgetArea::pluck('name','id')->toArray()
                        )
                        ->required(),
                    Select::make('widget_type_id')
                        ->label('Widget Type')
                        ->options(
                            WidgetType::pluck('name','id')->toArray()
                        )
                        ->afterStateUpdated(function (callable $set, $state) { 
                            $widgetType = WidgetType::find($state);
                            if($widgetType)
                            {
                                $set('fieldsIds', $widgetType->fieldsIds);
                            }
                        })
                        ->reactive()
                        ->required(),
                    Hidden::make('fieldsIds')
                    ->reactive(),
                    Repeater::make('values')
                    ->schema(function (callable $get) {

                        // Fetch fields configuration from the database
                        $fields = WidgetsField::whereIn('id', $get('fieldsIds'))
                            ->get(['fields.name', 'fields.type', 'fields.options', 'fields.id'])
                            ->toArray();

                        // Fetch existing values from the database for a specific widget (assuming widget_id is 1 here)
                        $values = WidgetField::where('widget_id', $get('id'))
                            ->whereIn('widget_field_id', $get('fieldsIds'))
                            ->get(['widget_field_id', 'value'])
                            ->pluck('value', 'widget_field_id') // Pluck values with field id as key
                            ->toArray();

                        // Map the fields to generate form components dynamically
                        return collect($fields)->map(function ($field) use ($values) {

                            $component = match ($field['type']) {
                                'text' => Forms\Components\TextInput::make($field['name']),
                                'textarea' => Forms\Components\Textarea::make($field['name']),
                                'number' => Forms\Components\TextInput::make($field['name'])->numeric(),
                                'select' => Forms\Components\Select::make($field['name'])
                                    ->options($field['options'] ?? []),
                                'checkbox' => Forms\Components\Checkbox::make($field['name']),
                                'radio' => Forms\Components\Radio::make($field['name'])
                                    ->options($field['options'] ?? []),
                                'toggle' => Forms\Components\Toggle::make($field['name']),
                                'color' => Forms\Components\ColorPicker::make($field['name']),
                                'date' => Forms\Components\DatePicker::make($field['name']),
                                'datetime' => Forms\Components\DateTimePicker::make($field['name']),
                                'time' => Forms\Components\TimePicker::make($field['name']),
                                'file' => Forms\Components\FileUpload::make($field['name']),
                                'image' => Forms\Components\FileUpload::make($field['name'])->image(),
                                'richeditor' => Forms\Components\RichEditor::make($field['name']),
                                'markdown' => Forms\Components\MarkdownEditor::make($field['name']),
                                'tags' => Forms\Components\TagsInput::make($field['name']),
                                'password' => Forms\Components\TextInput::make($field['name'])->password(),
                                default => Forms\Components\TextInput::make($field['name']),
                            };

                            // Apply the default value from the existing values or set it to empty if not found
                            $component->default($values[$field['id']] ?? '');

                            // Apply validation rules if specified
                            if (isset($field['validation'])) {
                                $component->rules($field['validation']);
                            }

                            // Set a user-friendly label
                            return $component->label(ucfirst(str_replace('_', ' ', $field['name'])));
                        })->toArray();

                    })
                    ->label('Configurations')
                    ->maxItems(1)
                    ->minItems(1)
                    ->reorderable(false)
                    ->deletable(false)
                    ->required()
                    ->reactive()
                    ->defaultItems(1)
                    ->addActionLabel('Display Fields')
                    ->columnSpanFull()
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->badge()
                ->color('success')
                ->label('Widget'),
                TextColumn::make('type.name')
                ->badge()
                ->color('primary')
                ->label('Widget Type'),
                SelectColumn::make('widget_area_id')
                    ->options(WidgetArea::pluck('name','id')->toArray())
                    ->label('Widget Area'),
                TextColumn::make('created_at')
                    ->dateTime('d, M Y h:s A')
                    ->badge()
                    ->color('success')
                    ->label('Created at'),
            ])
            ->filters([
                SelectFilter::make('widget_area_id')
                    ->options(WidgetArea::pluck('name','id')->toArray()),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->ordered());
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWidgets::route('/'),
            'create' => Pages\CreateWidget::route('/create'),
            'edit' => Pages\EditWidget::route('/{record}/edit'),
        ];
    }
}
