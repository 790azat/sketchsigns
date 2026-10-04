<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('status')
                ->label('Change status')
                ->icon('heroicon-o-arrow-path')
                ->fillForm(fn (Order $record) => ['status' => $record->status])
                ->schema([Select::make('status')->options(Order::STATUSES)->required()])
                ->action(fn (Order $record, array $data) => $record->update($data)),
            DeleteAction::make(),
        ];
    }
}
