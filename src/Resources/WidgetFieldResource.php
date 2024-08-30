<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetFieldResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\Field;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetFieldResource extends Resource
{
    protected static ?string $model = Field::class;

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
                Forms\Components\TextInput::make('name')
                    ->label('Field Name')
                    ->required(),
    
                    Forms\Components\Select::make('type')
                    ->label('Field Type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'select' => 'Select',
                        'checkbox' => 'Checkbox',
                        'radio' => 'Radio',
                        'toggle' => 'Toggle',
                        'color' => 'Color Picker',
                        'date' => 'Date Picker',
                        'datetime' => 'Date Time Picker',
                        'time' => 'Time Picker',
                        'file' => 'File Upload',
                        'image' => 'Image Upload',
                        'richeditor' => 'Rich Editor',
                        'markdown' => 'Markdown Editor',
                        'tags' => 'Tags Input',
                        'password' => 'Password',
                    ])
                    ->required(),
    
                Forms\Components\Textarea::make('options')
                    ->label('Options')
                    ->helperText('Provide additional options in JSON format (e.g., {"default": "value", "validation": "required|max:255"})'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->badge()
                ->color('success')
                ->label('Field Name'),
                TextColumn::make('type')
                ->badge()
                ->color('success')
                ->label('Field Type'),
                TextColumn::make('widgets_count')
                ->counts('widgets')
                ->badge()
                ->color('success')
                ->label('Used'),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListWidgetFields::route('/'),
            'create' => Pages\CreateWidgetField::route('/create'),
            'edit' => Pages\EditWidgetField::route('/{record}/edit'),
        ];
    }
}
