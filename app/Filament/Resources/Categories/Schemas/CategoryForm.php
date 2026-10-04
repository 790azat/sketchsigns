<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Support\Catalog;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, $set, string $operation) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->helperText('Page address: /product-category/{slug}'),
                        Select::make('parent_id')
                            ->label('Parent category')
                            ->relationship('parent', 'name', fn ($query, $record) => $record ? $query->whereKeyNot($record->getKey()) : $query)
                            ->placeholder('None (top level)'),
                        TextInput::make('position')->numeric()->default(0)->helperText('Lower comes first'),
                        RichEditor::make('description')->columnSpanFull(),
                    ]),
                Section::make('Photo')
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('preview')
                            ->hiddenLabel()
                            ->state(fn ($record) => $record?->image ? Catalog::media($record->image) : null)
                            ->imageHeight(160)
                            ->visible(fn ($record) => filled($record?->image)),
                        TextInput::make('image')->label('Photo URL')->maxLength(1024),
                    ]),
            ]);
    }
}
