<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Support\Money;
use App\Support\Catalog;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Product')
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set, $get, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->helperText('Page address: /product/{slug}'),
                        Textarea::make('short_description')->rows(3)->columnSpanFull(),
                        RichEditor::make('description')->columnSpanFull(),
                    ]),

                Section::make('Visibility')
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('is_active')->label('Shown on the site')->default(true),
                        Toggle::make('in_stock')->default(true),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->preload(),
                        Select::make('type')
                            ->options(['simple' => 'Simple', 'variable' => 'With options (variations)'])
                            ->default('simple')
                            ->required(),
                        TextInput::make('position')->numeric()->default(0)->helperText('Lower comes first'),
                    ]),

                Section::make('Price')
                    ->columnSpan(2)
                    ->columns(2)
                    ->description('“From” price on cards. Products with options take the exact price from their variations.')
                    ->schema([
                        Money::input('price_min')->label('Price from')->required(),
                        Money::input('price_max')->label('Price up to'),
                    ]),

                Section::make('Photos')
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('preview')
                            ->hiddenLabel()
                            ->state(fn ($record) => $record?->image ? Catalog::media($record->image) : null)
                            ->imageHeight(160)
                            ->visible(fn ($record) => filled($record?->image)),
                        TextInput::make('image')->label('Main photo URL')->maxLength(1024),
                        Repeater::make('gallery')
                            ->simple(TextInput::make('url')->maxLength(1024))
                            ->defaultItems(0)
                            ->reorderable(),
                    ]),

                Section::make('Options')
                    ->columnSpanFull()
                    ->description('Option groups the customer picks from (Size, Material…). Each variation below sets the price for one combination.')
                    ->collapsed()
                    ->schema([
                        Repeater::make('options')
                            ->hiddenLabel()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state) => $state['name'] ?? null)
                            ->collapsible()
                            ->schema([
                                TextInput::make('name')->required(),
                                Repeater::make('terms')
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->schema([
                                        TextInput::make('name')->label('Choice')->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set, $get) => blank($get('slug')) ? $set('slug', Str::slug($state)) : null),
                                        TextInput::make('slug')->required(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
