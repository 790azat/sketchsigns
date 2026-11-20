<?php

namespace App\Filament\Resources\Redirects\Pages;

use App\Filament\Resources\Redirects\RedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRedirects extends ManageRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }

    public function getSubheading(): ?string
    {
        return 'Addresses from the old WordPress site are already redirected in code (config/redirects.php). Add extra ones here; these take priority.';
    }
}
