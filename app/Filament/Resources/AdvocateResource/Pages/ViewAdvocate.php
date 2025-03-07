<?php

namespace App\Filament\Resources\AdvocateResource\Pages;

use App\Filament\Resources\AdvocateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdvocate extends ViewRecord
{
    protected static string $resource = AdvocateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
