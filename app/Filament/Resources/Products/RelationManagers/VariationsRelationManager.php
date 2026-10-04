<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Filament\Support\Money;
use App\Support\Catalog;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VariationsRelationManager extends RelationManager
{
    protected static string $relationship = 'variations';

    public function form(Schema $schema): Schema
    {
        // One select per option group of the product; "Any" leaves the value empty.
        $selects = collect($this->getOwnerRecord()->options ?? [])->map(fn (array $group) => Select::make('options.'.$group['name'])
            ->label($group['name'])
            ->options(['' => 'Any'] + collect($group['terms'] ?? [])->pluck('name', 'slug')->all())
            ->default('')
            ->selectablePlaceholder(false))->all();

        return $schema->components([
            ...$selects,
            Money::input('price')->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        $product = $this->getOwnerRecord();

        return $table
            ->columns([
                TextColumn::make('options')
                    ->label('Combination')
                    ->state(fn ($record) => collect($record->options)->map(function ($slug, $name) use ($product) {
                        $term = collect(collect($product->options)->firstWhere('name', $name)['terms'] ?? [])->firstWhere('slug', $slug);

                        return $name.': '.($slug === '' ? 'Any' : ($term['name'] ?? $slug));
                    })->implode(' · '))
                    ->wrap(),
                TextColumn::make('price')->formatStateUsing(fn ($state) => Catalog::money($state))->sortable(),
            ])
            ->headerActions([CreateAction::make()])
            ->recordActions([EditAction::make(), DeleteAction::make()]);
    }
}
