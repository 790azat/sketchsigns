<?php

namespace App\Filament\Resources\QuoteRequests\Tables;

use App\Models\QuoteRequest;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuoteRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('product')->toggleable(),
                TextColumn::make('details')->limit(60)->toggleable(),
                SelectColumn::make('status')->options(QuoteRequest::STATUSES)->selectablePlaceholder(false),
            ])
            ->filters([SelectFilter::make('status')->options(QuoteRequest::STATUSES)])
            ->recordActions([ViewAction::make()]);
    }
}
