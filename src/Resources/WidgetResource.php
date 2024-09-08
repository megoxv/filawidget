<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\Field as WidgetsField;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
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

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function shouldRegisterNavigation(): bool
    {
        return config('filawidget.should_register_navigation_widgets');
    }
    
    public static function getLabel(): ?string
    {
        return __('filawidget::filawidget.Widget');
    }

    public static function getPluralLabel(): ?string
    {
        return __('filawidget::filawidget.Widgets');
    }

    public static function getBreadcrumb(): string
    {
        return __('filawidget::filawidget.Widget');
    }

    public static function getNavigationLabel(): string
    {
        return __('filawidget::filawidget.Widget');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filawidget::filawidget.Appearance Management');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('name')
                        ->label(__('filawidget::filawidget.Name'))
                        ->required()
                        ->columnSpanFull(),
                    Select::make('widget_area_id')
                        ->label(__('filawidget::filawidget.Area'))
                        ->options(
                            WidgetArea::pluck('name','id')->toArray()
                        )
                        ->required()
                        ->searchable()
                        ->default(
                            request()->has('area_id') ? request()->query('area_id') : null
                        ),
                    Select::make('widget_type_id')
                        ->label(__('filawidget::filawidget.Widget Type'))
                        ->searchable()
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
                    RichEditor::make('description')
                        ->label(__('filawidget::filawidget.Description'))
                        ->columnSpanFull(),
                    Toggle::make('status')
                        ->label(__('filawidget::filawidget.Status')),
                    Hidden::make('fieldsIds')
                    ->reactive(),
                    Repeater::make('values')
                    ->label(__('filawidget::filawidget.Appearance'))
                    ->schema(function (callable $get) {

                        $fieldsIds = $get('fieldsIds') ?? [];
                        
                        $widgetId = $get('id') ?? null;

                        $fields = [];
                        if (is_array($fieldsIds) && count($fieldsIds) > 0) {
                            $fields = WidgetsField::whereIn('id', $fieldsIds)
                                ->get(['fields.name', 'fields.type', 'fields.options', 'fields.id'])
                                ->toArray();
                        }

                        $values = [];
                        if (!is_null($widgetId) && is_array($fieldsIds) && count($fieldsIds) > 0) {
                            $values = WidgetField::where('widget_id', $widgetId)
                                ->whereIn('widget_field_id', $fieldsIds)
                                ->get(['widget_field_id', 'value'])
                                ->pluck('value', 'widget_field_id')
                                ->toArray();
                        }

                        return collect($fields)->map(function ($field) use ($values) {

                            $options = json_decode($field['options'], true);

                            $defaultValue = $options['default'] ?? '';

                            $component = match ($field['type']) {
                                'text' => TextInput::make($field['name']),
                                'textarea' => Textarea::make($field['name']),
                                'number' => TextInput::make($field['name'])->numeric(),
                                'select' => Select::make($field['name'])
                                    ->options($field['options'] ?? []),
                                'checkbox' => Checkbox::make($field['name']),
                                'radio' => Radio::make($field['name'])
                                    ->options($field['options'] ?? []),
                                'toggle' => Toggle::make($field['name']),
                                'color' => ColorPicker::make($field['name']),
                                'date' => DatePicker::make($field['name']),
                                'datetime' => DateTimePicker::make($field['name']),
                                'time' => TimePicker::make($field['name']),
                                'file' => FileUpload::make($field['name']),
                                'image' => FileUpload::make($field['name'])->image(),
                                'richeditor' => RichEditor::make($field['name']),
                                'markdown' => MarkdownEditor::make($field['name']),
                                'tags' => TagsInput::make($field['name']),
                                'password' => TextInput::make($field['name'])->password(),
                                default => TextInput::make($field['name']),
                            };

                            $component->default($values[$field['id']] ?? $defaultValue);
                            
                            if (isset($field['validation'])) {
                                $component->rules($field['validation']);
                            }

                            return $component->label(ucfirst(str_replace('_', ' ', $field['name'])));
                        })->toArray();

                    })
                    ->label(__('filawidget::filawidget.Configurations'))
                    ->reorderable(false)
                    ->deletable(false)
                    ->reactive()
                    ->defaultItems(1)
                    ->addActionLabel(__('filawidget::filawidget.Display Fields'))
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
                ->label(__('filawidget::filawidget.Widget')),
                TextColumn::make('type.name')
                ->badge()
                ->color('primary')
                ->label(__('filawidget::filawidget.Widget Type')),
                SelectColumn::make('widget_area_id')
                    ->options(WidgetArea::pluck('name','id')->toArray())
                    ->label(__('filawidget::filawidget.Widget Area')),
                ToggleColumn::make('status')
                    ->label(__('filawidget::filawidget.Status')),
                TextColumn::make('created_at')
                    ->dateTime('d, M Y h:s A')
                    ->badge()
                    ->color('success')
                    ->label(__('filawidget::filawidget.Created at')),
            ])
            ->filters([
                SelectFilter::make('widget_area_id')
                    ->label(__('filawidget::filawidget.Widget Area'))
                    ->options(WidgetArea::pluck('name','id')->toArray()),
                Filter::make('created_at')
                    ->label(__('filawidget::filawidget.Created at'))
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
