<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\Order;
use App\Support\Catalog;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Items')
                    ->columnSpan(2)
                    ->schema([
                        RepeatableEntry::make('lines')
                            ->hiddenLabel()
                            ->columns(4)
                            ->schema([
                                TextEntry::make('name')->columnSpan(2)->weight('bold'),
                                TextEntry::make('quantity'),
                                TextEntry::make('total')->formatStateUsing(fn ($state) => Catalog::money($state)),
                                TextEntry::make('options_text')->label('Options')->columnSpanFull()->placeholder('—'),
                                TextEntry::make('artwork'),
                                TextEntry::make('notes')->columnSpan(3)->placeholder('—'),
                            ]),
                        TextEntry::make('subtotal')
                            ->formatStateUsing(fn ($state) => Catalog::money($state))
                            ->size('lg')
                            ->weight('bold'),
                    ]),
                Section::make('Customer')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('number')->copyable(),
                        TextEntry::make('status')->badge()->formatStateUsing(fn ($state) => Order::STATUSES[$state] ?? $state),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('name'),
                        TextEntry::make('email')->url(fn ($state) => "mailto:$state"),
                        TextEntry::make('phone')->url(fn ($state) => "tel:$state"),
                        TextEntry::make('company')->placeholder('—'),
                        TextEntry::make('delivery')->formatStateUsing(fn ($state) => ['ship' => 'Shipping', 'pickup' => 'Pickup', 'install' => 'Installation'][$state] ?? $state),
                        TextEntry::make('address')->placeholder('—'),
                        TextEntry::make('notes')->placeholder('—'),
                    ]),
            ]);
    }
}
