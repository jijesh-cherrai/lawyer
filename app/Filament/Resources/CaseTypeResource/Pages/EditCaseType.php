<?php

namespace App\Filament\Resources\CaseTypeResource\Pages;

use App\Filament\Resources\CaseTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaseType extends EditRecord
{
    protected static string $resource = CaseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
