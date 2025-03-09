<?php

namespace App\Filament\Resources\CaseDiaryResource\Pages;

use App\Filament\Resources\CaseDiaryResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCaseDiaries extends ListRecords
{
    protected static string $resource = CaseDiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            "All" => Tab::make('All'),
            "7 Days" => Tab::make('7 Days')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return  $query
                            ->where('upcoming_case_date', ">=", now()->format('Y-m-d'))
                            ->where('upcoming_case_date', "<=", now()->addDay(7)->format('Y-m-d'));
                    }
                ),
            "Next Week" => Tab::make('Next Week')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        $monday = now()->next(\Carbon\Carbon::MONDAY)->format('Y-m-d');
                        $saturday = now()->next(\Carbon\Carbon::SATURDAY)->format('Y-m-d');

                        return $query
                            ->whereBetween('upcoming_case_date', [$monday, $saturday]);
                    }
                ),
            "30 Days" => Tab::make('30 Days')
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query
                            ->whereBetween('upcoming_case_date', [
                                now()->format('Y-m-d'),
                                now()->addDays(30)->format('Y-m-d')
                            ]);
                    }
                ),
        ];
    }
    public function getDefaultActiveTab(): string | int | null
    {
        return 'All';
    }
}
