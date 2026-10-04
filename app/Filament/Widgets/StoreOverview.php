<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use App\Models\QuoteRequest;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New orders', Order::where('status', 'new')->count()),
            Stat::make('New quote requests', QuoteRequest::where('status', 'new')->count()),
            Stat::make('Products on the site', Product::active()->count()),
        ];
    }
}
