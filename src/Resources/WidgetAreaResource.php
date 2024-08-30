<?php

namespace IbrahimBougaoua\Filawidget\Resources;

use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\Pages;
use IbrahimBougaoua\Filawidget\Resources\WidgetAreaResource\RelationManagers;
use IbrahimBougaoua\Filawidget\Models\WidgetArea;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WidgetAreaResource extends Resource
{
    protected static ?string $model = WidgetArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    
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
                    ->label('Area Name')
                    ->required(),
    
                Forms\Components\TextInput::make('identifier')
                    ->label('Identifier')
                    ->unique(ignoreRecord: true)
                    ->helperText('This identifier is used to reference the widget area in your code.')
                    ->required(),
                Toggle::make('status')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->badge()
                ->color('success')
                ->label('Area Name'),
                TextColumn::make('identifier')
                ->badge()
                ->color('primary')
                ->label('Identifier'),
                ToggleColumn::make('status')
                ->label('Status'),
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
            'index' => Pages\ListWidgetAreas::route('/'),
            'create' => Pages\CreateWidgetArea::route('/create'),
            'edit' => Pages\EditWidgetArea::route('/{record}/edit'),
        ];
    }
}
