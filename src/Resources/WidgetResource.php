<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Widget;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
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
    
    public static function getNavigationGroup(): ?string
    {
        return 'Appearance';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('widget_type_id')
                ->label('Widget Type')
                ->options(WidgetType::all()->pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateUpdated(fn ($state, callable $set) => $set('config', [])),

            Forms\Components\Select::make('widget_area_id')
                ->label('Widget Area')
                ->options(WidgetArea::all()->pluck('name', 'id'))
                ->required(),
                Forms\Components\Repeater::make('config')
                ->schema(function (callable $get) {
                    $widgetTypeId = $get('widget_type_id');
                    if (!$widgetTypeId) {
                        return [];
                    }
            
                    $fields = WidgetField::where('widget_type_id', $widgetTypeId)->get();
            
                    return $fields->map(function ($field) {
                        $component = match ($field->type) {
                            'text' => Forms\Components\TextInput::make("config.{$field->name}"),
                            'textarea' => Forms\Components\Textarea::make("config.{$field->name}"),
                            'number' => Forms\Components\TextInput::make("config.{$field->name}")->numeric(),
                            'select' => Forms\Components\Select::make("config.{$field->name}")
                                         ->options($field->options['options'] ?? []),
                            'checkbox' => Forms\Components\Checkbox::make("config.{$field->name}"),
                            'radio' => Forms\Components\Radio::make("config.{$field->name}")
                                         ->options($field->options['options'] ?? []),
                            'toggle' => Forms\Components\Toggle::make("config.{$field->name}"),
                            'color' => Forms\Components\ColorPicker::make("config.{$field->name}"),
                            'date' => Forms\Components\DatePicker::make("config.{$field->name}"),
                            'datetime' => Forms\Components\DateTimePicker::make("config.{$field->name}"),
                            'time' => Forms\Components\TimePicker::make("config.{$field->name}"),
                            'file' => Forms\Components\FileUpload::make("config.{$field->name}"),
                            'image' => Forms\Components\FileUpload::make("config.{$field->name}")->image(),
                            'richeditor' => Forms\Components\RichEditor::make("config.{$field->name}"),
                            'markdown' => Forms\Components\MarkdownEditor::make("config.{$field->name}"),
                            'tags' => Forms\Components\TagsInput::make("config.{$field->name}"),
                            'password' => Forms\Components\TextInput::make("config.{$field->name}")->password(),
                            default => Forms\Components\TextInput::make("config.{$field->name}"),
                        };
            
                        // Apply default value if specified
                        if (isset($field->options['default'])) {
                            $component->default($field->options['default']);
                        }
            
                        // Apply validation rules if specified
                        if (isset($field->options['validation'])) {
                            $component->rules($field->options['validation']);
                        }
            
                        return $component->label(ucfirst(str_replace('_', ' ', $field->name)));
                    })->toArray();
                })
                ->label('Configuration')
                ->required(),            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('type.name')->label('Widget Type'),
                Tables\Columns\TextColumn::make('area.name')->label('Widget Area'),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
