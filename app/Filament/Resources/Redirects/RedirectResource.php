<?php

namespace App\Filament\Resources\Redirects;

use App\Filament\Resources\Redirects\Pages\ManageRedirects;
use App\Models\Redirect;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUturnRight;

    protected static string|\UnitEnum|null $navigationGroup = 'SEO';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('from_path')
                ->label('Old address')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->dehydrateStateUsing(fn ($state) => Redirect::normalize($state))
                ->placeholder('/old-page')
                ->helperText('Path only, e.g. /custom-signs. Used only when no page exists at that address.'),
            TextInput::make('to_path')
                ->label('New address')
                ->required()
                ->maxLength(1024)
                ->placeholder('/product-category/signs'),
            Select::make('status_code')
                ->label('Type')
                ->options([301 => '301 — moved permanently (SEO)', 302 => '302 — temporary'])
                ->default(301)
                ->required(),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('from_path')
            ->columns([
                TextColumn::make('from_path')->label('Old address')->searchable()->sortable(),
                TextColumn::make('to_path')->label('New address')->searchable(),
                TextColumn::make('status_code')->label('Type'),
                TextColumn::make('hits')->numeric()->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return ['index' => ManageRedirects::route('/')];
    }
}
