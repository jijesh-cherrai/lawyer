<?php

namespace App\Filament\Resources\CaseDiaryResource\Pages;

use App\Filament\Resources\CaseDiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaseDiary extends EditRecord
{
    protected static string $resource = CaseDiaryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirects to the list page
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
