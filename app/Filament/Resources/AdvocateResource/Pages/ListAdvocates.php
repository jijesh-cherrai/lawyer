<?php

namespace App\Filament\Resources\AdvocateResource\Pages;

use App\Filament\Resources\AdvocateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvocates extends ListRecords
{
    protected static string $resource = AdvocateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->slideOver(),
        ];
    }
}
