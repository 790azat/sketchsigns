<?php

namespace App\Filament\Resources\QuoteRequests\Pages;

use App\Filament\Resources\QuoteRequests\QuoteRequestResource;
use App\Models\QuoteRequest;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ViewRecord;

class ViewQuoteRequest extends ViewRecord
{
    protected static string $resource = QuoteRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('status')
                ->label('Change status')
                ->icon('heroicon-o-arrow-path')
                ->fillForm(fn (QuoteRequest $record) => ['status' => $record->status])
                ->schema([Select::make('status')->options(QuoteRequest::STATUSES)->required()])
                ->action(fn (QuoteRequest $record, array $data) => $record->update($data)),
            DeleteAction::make(),
        ];
    }
}
