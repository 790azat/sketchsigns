<?php

namespace App\Filament\Resources\Categories\Tables;

use App\Support\Catalog;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('position')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->state(fn ($record) => $record->image ? Catalog::media($record->image) : null)
                    ->imageSize(40),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('parent.name')->label('Parent')->placeholder('—'),
                TextColumn::make('products_count')->counts('products')->label('Products')->sortable(),
                TextColumn::make('position')->sortable(),
            ])
            ->recordActions([EditAction::make()]);
    }
}
