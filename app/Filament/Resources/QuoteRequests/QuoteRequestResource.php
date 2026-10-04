<?php

namespace App\Filament\Resources\QuoteRequests;

use App\Filament\Resources\QuoteRequests\Pages\ListQuoteRequests;
use App\Filament\Resources\QuoteRequests\Pages\ViewQuoteRequest;
use App\Filament\Resources\QuoteRequests\Tables\QuoteRequestsTable;
use App\Models\QuoteRequest;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|\UnitEnum|null $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Quote requests';

    public static function getNavigationBadge(): ?string
    {
        return (string) (QuoteRequest::where('status', 'new')->count() ?: '') ?: null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Request')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextEntry::make('details')->columnSpanFull(),
                        TextEntry::make('product')->placeholder('—'),
                        TextEntry::make('size')->placeholder('—'),
                        TextEntry::make('quantity')->placeholder('—'),
                        TextEntry::make('needed_by')->date()->placeholder('—'),
                        TextEntry::make('artwork_link')->url(fn ($state) => $state, shouldOpenInNewTab: true)->placeholder('—')->columnSpanFull(),
                    ]),
                Section::make('Contact')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('status')->badge()->formatStateUsing(fn ($state) => QuoteRequest::STATUSES[$state] ?? $state),
                        TextEntry::make('created_at')->dateTime(),
                        TextEntry::make('name'),
                        TextEntry::make('email')->url(fn ($state) => "mailto:$state"),
                        TextEntry::make('phone')->url(fn ($state) => $state ? "tel:$state" : null)->placeholder('—'),
                        TextEntry::make('company')->placeholder('—'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return QuoteRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuoteRequests::route('/'),
            'view' => ViewQuoteRequest::route('/{record}'),
        ];
    }
}
