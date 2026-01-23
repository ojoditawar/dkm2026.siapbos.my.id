<?php

namespace App\Filament\Resources\SubReks;

use App\Filament\Resources\Reks\RelationManagers\SubRekRelationManager;
use App\Filament\Resources\SubReks\Pages\CreateSubRek;
use App\Filament\Resources\SubReks\Pages\EditSubRek;
use App\Filament\Resources\SubReks\Pages\ListSubReks;
use App\Filament\Resources\SubReks\RelationManagers\RekeningsRelationManager;
use App\Filament\Resources\SubReks\Schemas\SubRekForm;
use App\Filament\Resources\SubReks\Tables\SubReksTable;
use App\Models\SubRek;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubRekResource extends Resource
{
    protected static ?string $model = SubRek::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'akun';

    public static function form(Schema $schema): Schema
    {
        return SubRekForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubReksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RekeningsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubReks::route('/'),
            'create' => CreateSubRek::route('/create'),
            'edit' => EditSubRek::route('/{record}/edit'),
        ];
    }
}
