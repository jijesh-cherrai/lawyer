<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseDiaryResource\Pages;
use App\Models\Advocate;
use App\Models\CaseDiary;
use App\Models\CaseFollowup;
use App\Models\CaseType;
use App\Models\Court;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaseDiaryResource extends Resource
{
    protected static ?string $model = CaseDiary::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make()
                        ->schema([
                            Select::make('court_id')
                                ->label('Court')
                                ->placeholder('Select Court')
                                ->relationship('court', 'name')
                                ->required(),
                            TagsInput::make('party_names')
                                ->placeholder('Enter party names by giving comma (,)')
                                ->splitKeys(['Tab', ','])
                                ->separator(',')
                                ->required(),
                            TextInput::make('mobile')
                                ->placeholder('Enter mobile number')
                                ->minLength(10)
                                ->maxLength(10),
                            TextInput::make('opposit_lawyer')
                                ->placeholder('Enter opposit lawyer')
                                ->maxLength(255),
                            DatePicker::make('upcoming_case_date')
                                ->label('Next hearing date')
                                ->placeholder('Enter next hearing date')
                                ->native(false)
                                ->required(),
                            Textarea::make('notes')
                                ->placeholder('Enter additional Notes if any')
                                ->columnSpanFull(),
                            ToggleButtons::make('status')
                                ->options([
                                    'open' => 'Open',
                                    'closed' => 'Closed',
                                ])
                                ->colors([
                                    'open' => 'success',
                                    'closed' => 'danger',
                                ])
                                ->visibleOn('edit')
                                ->grouped()
                                ->inline()
                        ])
                        ->grow(),
                    Section::make("Cases")
                        ->schema([
                            Repeater::make('caseDetails')
                                ->relationship('caseDetails') // Relationship with CaseDetail Model
                                ->schema([
                                    Select::make('case_type')
                                        ->label('Case Type')
                                        ->options(fn() => CaseType::query()->pluck('type', 'id'))
                                        ->required(),
                                    TextInput::make('case_number')
                                        ->label('Case Number')
                                        ->required(),
                                ])
                                ->itemLabel(fn(array $state): ?string => $state['case_number'] ?? null)
                                ->addActionLabel('Add Another Case')
                                ->deletable(fn($state) => count($state) > 1)
                                ->columns(2)
                                ->minItems(1)
                                ->defaultItems(1)
                                ->deleteAction(
                                    fn($action) => $action->requiresConfirmation(),
                                )
                            // ->grid(2)
                        ])
                        ->grow()
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('court.name')
                    ->sortable(),
                TextColumn::make('party_names')
                    ->separator(',')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mobile')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('upcoming_case_date')
                    ->label("Next Hearing")
                    ->date('d M, Y')
                    ->sortable(),
                TextColumn::make('caseDetails.case_number')
                    ->label('Cases')
                    ->badge(),
                TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('opposit_lawyer')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort("upcoming_case_date", "asc")
            ->filters([
                Filter::make('Hearing Date')
                    ->form([
                        DatePicker::make('date_from')
                            ->native(false)
                            ->displayFormat('d-m-Y'),
                        DatePicker::make('date_to')
                            ->native(false)
                            ->displayFormat('d-m-Y'),

                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('upcoming_case_date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'],
                                fn(Builder $query, $date): Builder => $query->whereDate('upcoming_case_date', '<=', $date),
                            );
                    })->indicator("Hearing Date"),
                SelectFilter::make('court')
                    ->options(fn() => Court::query()->pluck('name', 'id'))
                    ->attribute('court_id'),

                TernaryFilter::make('status')
                    ->label("Case Status")
                    ->placeholder("All Cases")
                    ->trueLabel('Open Case Only')
                    ->falseLabel('Close Case Only')
                    // ->default(true)
                    ->queries(
                        true: fn(Builder $query) => $query->where('status', 'open'),
                        false: fn(Builder $query) => $query->where('status', 'closed'),
                        blank: fn(Builder $query) => $query,
                    ),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->striped()
            ->deferLoading()
            ->extremePaginationLinks()
            ->actions([
                ActionGroup::make([
                    Action::make('Follow up')
                        ->icon('heroicon-o-calendar-days')
                        ->form([
                            Section::make()
                                ->schema([
                                    Select::make('advocate')
                                        ->required()
                                        ->options(fn() => Advocate::where('status', 'active')->pluck('name', 'id')),
                                    Textarea::make('note'),
                                    DatePicker::make('next_hearing_date')
                                        ->required()
                                        ->native(false)
                                ])->columns(2)
                        ])
                        ->action(function ($record, array $data) {

                            CaseFollowup::create([
                                'case_diary_id' => $record->id,
                                'advocate_attended' => $data['advocate'],
                                'next_hearing' => $record->upcoming_case_date ?? NULL,
                                'notes' => $data['note'] ?? NULL,
                            ]);
                            $record->upcoming_case_date = $data['next_hearing_date'];
                            $record->save();
                            Notification::make()
                                ->success()
                                ->title('Followup Updated')
                                ->send();
                        })->slideOver(),
                    Tables\Actions\EditAction::make()->slideOver(),
                    Tables\Actions\ViewAction::make()->slideOver(),
                    Action::make('History')
                        ->icon('heroicon-o-clock')
                        ->modalHeading('Case History')
                        ->modalContent(fn($record) => view('component.case-history', ['record' => $record]))
                        ->modalSubmitAction(false)
                        ->slideOver()
                ]),
            ], ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Split::make([
                \Filament\Infolists\Components\Section::make("")->schema([
                    TextEntry::make('court.name')->inlineLabel(),
                    TextEntry::make('party_names')
                        ->inlineLabel()
                        ->badge()
                        ->separator(','),
                    TextEntry::make('mobile')
                        ->inlineLabel(),
                    TextEntry::make('opposit_lawyer')
                        ->inlineLabel(),
                    TextEntry::make('upcoming_case_date')
                        ->inlineLabel()
                        ->label('Next Hearing'),
                    TextEntry::make('notes')
                        ->inlineLabel(),
                    TextEntry::make('status')
                        ->badge()
                        ->inlineLabel(),
                ])
                    ->grow(),
                \Filament\Infolists\Components\Section::make("Case List")->schema([

                    \Filament\Infolists\Components\RepeatableEntry::make("caseDetails")
                        ->label("")
                        ->schema([
                            TextEntry::make('case_number')
                                ->label('Case Number'),
                            TextEntry::make('caseType.type')
                                ->label('Case Type'),
                        ])->columns(2)
                ]),
            ])->columnSpanFull(),
            \Filament\Infolists\Components\Section::make("Case Followup")->schema([

                \Filament\Infolists\Components\RepeatableEntry::make("caseFollowup")
                    ->label("")
                    ->schema([
                        TextEntry::make('next_hearing')
                            ->label('Hearing Date'),
                        TextEntry::make('advocate.name')
                            ->label('Attented By'),
                        TextEntry::make('notes')
                            ->label('Notes'),
                    ])->columns(3)
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseDiaries::route('/'),
            // 'create' => Pages\CreateCaseDiary::route('/create'),
            // 'view' => Pages\ViewCaseDiary::route('/{record}'),
            // 'edit' => Pages\EditCaseDiary::route('/{record}/edit'),
        ];
    }
}
