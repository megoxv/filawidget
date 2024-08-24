<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetTypeResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\WidgetType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetTypeResource extends Resource
{
    protected static ?string $model = WidgetType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    public static function getNavigationGroup(): ?string
    {
        return 'Appearance';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Widget Type Name')
                    ->required(),
    
                Forms\Components\TextInput::make('class')
                    ->label('Widget Class')
                    ->helperText('Fully qualified class name (e.g., MyWidgets\Widgets\TextWidget)')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->label('Widget Type Name'),
                Tables\Columns\TextColumn::make('class')->label('Widget Class'),
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
            'index' => Pages\ListWidgetTypes::route('/'),
            'create' => Pages\CreateWidgetType::route('/create'),
            'edit' => Pages\EditWidgetType::route('/{record}/edit'),
        ];
    }
}
