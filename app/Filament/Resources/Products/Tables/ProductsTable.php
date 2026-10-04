<?php

namespace App\Filament\Resources\Products\Tables;

use App\Support\Catalog;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('position')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->state(fn ($record) => Catalog::media($record->image))
                    ->imageSize(48),
                TextColumn::make('name')->searchable()->sortable()->wrap(),
                TextColumn::make('categories.name')->badge()->toggleable(),
                TextColumn::make('price_min')
                    ->label('From')
                    ->formatStateUsing(fn ($state) => Catalog::money($state))
                    ->sortable(),
                TextColumn::make('variations_count')->counts('variations')->label('Variations')->toggleable(),
                ToggleColumn::make('is_active')->label('Shown'),
                ToggleColumn::make('in_stock')->toggleable(),
                TextColumn::make('position')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('categories')->relationship('categories', 'name')->multiple()->preload(),
                TernaryFilter::make('is_active')->label('Shown on the site'),
            ])
            ->recordActions([
                Action::make('open')
                    ->label('Open')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn ($record) => route('product', $record->slug), shouldOpenInNewTab: true),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
