<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetAreaResource extends Resource
{
    protected static ?string $model = WidgetArea::class;

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
                    ->label('Area Name')
                    ->required(),
    
                Forms\Components\TextInput::make('identifier')
                    ->label('Identifier')
                    ->unique(ignoreRecord: true)
                    ->helperText('This identifier is used to reference the widget area in your code.')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->label('Area Name'),
                Tables\Columns\TextColumn::make('identifier')->label('Identifier'),
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
            'index' => Pages\ListWidgetAreas::route('/'),
            'create' => Pages\CreateWidgetArea::route('/create'),
            'edit' => Pages\EditWidgetArea::route('/{record}/edit'),
        ];
    }
}
