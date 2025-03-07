<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CaseTypeResource\Pages;
use App\Filament\Resources\CaseTypeResource\RelationManagers;
use App\Models\CaseType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CaseTypeResource extends Resource
{
    protected static ?string $model = CaseType::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-vertical';
    
    protected static ?string $navigationGroup = 'Data Center';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()->slideOver(),
                Tables\Actions\EditAction::make()->slideOver(),
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseTypes::route('/'),
            // 'create' => Pages\CreateCaseType::route('/create'),
            // 'view' => Pages\ViewCaseType::route('/{record}'),
            // 'edit' => Pages\EditCaseType::route('/{record}/edit'),
        ];
    }
}
