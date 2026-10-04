<?php

namespace App\Filament\Support;

use Filament\Forms\Components\TextInput;

/** Prices are stored in cents; admins edit them in dollars. */
class Money
{
    public static function input(string $name): TextInput
    {
        return TextInput::make($name)
            ->numeric()
            ->minValue(0)
            ->step(0.01)
            ->prefix('$')
            ->formatStateUsing(fn ($state) => $state === null ? null : number_format($state / 100, 2, '.', ''))
            ->dehydrateStateUsing(fn ($state) => (int) round(((float) $state) * 100));
    }
}
