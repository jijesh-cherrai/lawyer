<?php

namespace App\Filament\Resources\AdvocateResource\Pages;

use App\Filament\Resources\AdvocateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvocate extends EditRecord
{
    protected static string $resource = AdvocateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
