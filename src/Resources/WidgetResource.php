<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\Field as WidgetsField;
use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
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
                            $set('widget_type_id', $state);
                        })
                        ->reactive()
                        ->required(),
                    Hidden::make('fieldsIds')
                    ->reactive(),
                    Repeater::make('fields')
                        ->schema(function (callable $get) {
                            
                            $fields = WidgetsField::whereIn('id',$get('fieldsIds'))->get(['name','type','options','id'])->toArray();

                            return collect($fields)->map(function ($field) {
                                $component = match ($field['type']) {
                                    'text' => Forms\Components\TextInput::make("config.{$field['name']}"),
                                    'textarea' => Forms\Components\Textarea::make("config.{$field['name']}"),
                                    'number' => Forms\Components\TextInput::make("config.{$field['name']}")->numeric(),
                                    'select' => Forms\Components\Select::make("config.{$field['name']}")
                                                ->options($field['options'] ?? []),
                                    'checkbox' => Forms\Components\Checkbox::make("config.{$field['name']}"),
                                    'radio' => Forms\Components\Radio::make("config.{$field['name']}")
                                                ->options($field['options'] ?? []),
                                    'toggle' => Forms\Components\Toggle::make("config.{$field['name']}"),
                                    'color' => Forms\Components\ColorPicker::make("config.{$field['name']}"),
                                    'date' => Forms\Components\DatePicker::make("config.{$field['name']}"),
                                    'datetime' => Forms\Components\DateTimePicker::make("config.{$field['name']}"),
                                    'time' => Forms\Components\TimePicker::make("config.{$field['name']}"),
                                    'file' => Forms\Components\FileUpload::make("config.{$field['name']}"),
                                    'image' => Forms\Components\FileUpload::make("config.{$field['name']}")->image(),
                                    'richeditor' => Forms\Components\RichEditor::make("config.{$field['name']}"),
                                    'markdown' => Forms\Components\MarkdownEditor::make("config.{$field['name']}"),
                                    'tags' => Forms\Components\TagsInput::make("config.{$field['name']}"),
                                    'password' => Forms\Components\TextInput::make("config.{$field['name']}")->password(),
                                    default => Forms\Components\TextInput::make("config.{$field['name']}"),
                                };
                    
                                // Apply default value if specified
                                if (isset($field['default'])) {
                                    $component->default($field['default']);
                                }
                    
                                // Apply validation rules if specified
                                if (isset($field['validation'])) {
                                    $component->rules($field['validation']);
                                }
                    
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
                        ->columnSpanFull(),
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
                ->color('success')
                ->label('Widget Type'),
                TextColumn::make('area.name')
                ->badge()
                ->color('success')
                ->label('Widget Area'),
                TextColumn::make('order')
                ->badge()
                ->color('success')
                ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d, M Y h:s A')
                    ->badge()
                    ->color('success')
                    ->label('Created at'),
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
