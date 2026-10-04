<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use App\Support\Catalog;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('number')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable()->toggleable(),
                TextColumn::make('phone')->toggleable(),
                TextColumn::make('subtotal')->formatStateUsing(fn ($state) => Catalog::money($state))->sortable(),
                SelectColumn::make('status')->options(Order::STATUSES)->selectablePlaceholder(false),
            ])
            ->filters([
                SelectFilter::make('status')->options(Order::STATUSES),
            ])
            ->recordActions([ViewAction::make()]);
    }
}
