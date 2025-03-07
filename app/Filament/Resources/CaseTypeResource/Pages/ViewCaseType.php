<?php

namespace App\Filament\Resources\CaseTypeResource\Pages;

use App\Filament\Resources\CaseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCaseType extends ViewRecord
{
    protected static string $resource = CaseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
