<?php

namespace App\Filament\Resources\CaseDiaryResource\Pages;

use App\Filament\Resources\CaseDiaryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;


class CreateCaseDiary extends CreateRecord
{
    protected static string $resource = CaseDiaryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirects to the list page
    }
    protected function getFormActionss(): array
    {
        return [
            // Custom Create Button
            Action::make('save')
                ->label('Save Record') // Change button text
                ->color('success') // Change color
                ->icon('heroicon-o-check') // Change icon
                ->submit('create'),

            // Custom Create & Create Another Button
            Action::make('save_and_create_another')
                ->label('Save & Add New')
                ->color('primary')
                ->icon('heroicon-o-plus')
                ->submit('createAnother'),

            // Custom Cancel Button
            Action::make('cancel')
                ->label('Back to List') // Change text
                ->color('gray')
                ->icon('heroicon-o-arrow-left')
                ->url($this->getResource()::getUrl('index')), // Redirect to index page
        ];
    }
}
