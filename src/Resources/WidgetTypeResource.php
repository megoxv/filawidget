<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Widget;
use IbrahimBougaoua\Filawidget\Models\Field as WidgetsField;
use Filament\Forms;
use Filament\Forms\Components\Field;
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

class WidgetTypeResource extends Resource
{
    protected static ?string $model = WidgetType::class;

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
                    Select::make('fieldsIds')
                        ->label('Fields')
                        ->options(
                            WidgetsField::pluck('name','type','id')->toArray()
                        )
                        ->multiple()
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(fn (callable $set, $state) => $set('fields', $state))
                        ->columnSpanFull(),
                    Repeater::make('fields')
                        ->schema(function (callable $get) {
                            
                            $fields = $get('fieldsIds');

                            return collect($fields)->map(function ($field) {
                                $component = match ($field) {
                                    'text' => Forms\Components\TextInput::make("config.{$field}"),
                                    'textarea' => Forms\Components\Textarea::make("config.{$field}"),
                                    'number' => Forms\Components\TextInput::make("config.{$field}")->numeric(),
                                    'select' => Forms\Components\Select::make("config.{$field}")
                                                ->options($field->options['options'] ?? []),
                                    'checkbox' => Forms\Components\Checkbox::make("config.{$field}"),
                                    'radio' => Forms\Components\Radio::make("config.{$field}")
                                                ->options($field->options['options'] ?? []),
                                    'toggle' => Forms\Components\Toggle::make("config.{$field}"),
                                    'color' => Forms\Components\ColorPicker::make("config.{$field}"),
                                    'date' => Forms\Components\DatePicker::make("config.{$field}"),
                                    'datetime' => Forms\Components\DateTimePicker::make("config.{$field}"),
                                    'time' => Forms\Components\TimePicker::make("config.{$field}"),
                                    'file' => Forms\Components\FileUpload::make("config.{$field}"),
                                    'image' => Forms\Components\FileUpload::make("config.{$field}")->image(),
                                    'richeditor' => Forms\Components\RichEditor::make("config.{$field}"),
                                    'markdown' => Forms\Components\MarkdownEditor::make("config.{$field}"),
                                    'tags' => Forms\Components\TagsInput::make("config.{$field}"),
                                    'password' => Forms\Components\TextInput::make("config.{$field}")->password(),
                                    default => Forms\Components\TextInput::make("config.{$field}"),
                                };
                    
                                // Apply default value if specified
                                if (isset($field->options['default'])) {
                                    $component->default($field->options['default']);
                                }
                    
                                // Apply validation rules if specified
                                if (isset($field->options['validation'])) {
                                    $component->rules($field->options['validation']);
                                }
                    
                                return $component->label(ucfirst(str_replace('_', ' ', $field)));
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type.name')
                ->label('Widget Type'),
                TextColumn::make('area.name')
                ->label('Widget Area'),
                TextColumn::make('order')
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
