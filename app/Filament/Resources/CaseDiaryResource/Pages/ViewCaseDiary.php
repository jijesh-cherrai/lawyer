<?php

namespace App\Filament\Resources\CaseDiaryResource\Pages;

use App\Filament\Resources\CaseDiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCaseDiary extends ViewRecord
{
    protected static string $resource = CaseDiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
