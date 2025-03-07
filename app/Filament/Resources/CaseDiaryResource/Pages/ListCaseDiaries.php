<?php

namespace App\Filament\Resources\CaseDiaryResource\Pages;

use App\Filament\Resources\CaseDiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCaseDiaries extends ListRecords
{
    protected static string $resource = CaseDiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
