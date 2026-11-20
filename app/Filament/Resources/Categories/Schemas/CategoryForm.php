<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Support\Catalog;
use App\Support\Seo;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
                Section::make('SEO')
                    ->columnSpan(2)
                    ->description('How this page looks in Google. Leave empty to use the automatic text shown in grey.')
                    ->collapsible()
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Title in Google')
                            ->maxLength(255)
                            ->placeholder(fn ($record) => $record ? Seo::categoryTitle($record) : null)
                            ->helperText('Best under 60 characters.'),
                        Textarea::make('seo_description')
                            ->label('Description in Google')
                            ->rows(2)
                            ->maxLength(500)
                            ->placeholder(fn ($record) => $record ? Seo::categoryDescription($record) : null)
                            ->helperText('Best 120–160 characters.'),
                    ]),
            ]);
    }
}
