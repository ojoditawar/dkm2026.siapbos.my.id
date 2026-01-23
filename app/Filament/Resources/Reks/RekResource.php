<?php

namespace App\Filament\Resources\Reks;

use App\Filament\Resources\Reks\Pages\CreateRek;
use App\Filament\Resources\Reks\Pages\EditRek;
use App\Filament\Resources\Reks\Pages\ListReks;
use App\Filament\Resources\Reks\RelationManagers\SubRekRelationManager;
use App\Filament\Resources\Reks\Schemas\RekForm;
use App\Filament\Resources\Reks\Tables\ReksTable;
use App\Models\Rek;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RekResource extends Resource
{
    protected static ?string $model = Rek::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'akun';

    public static function form(Schema $schema): Schema
    {
        return RekForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SubRekRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReks::route('/'),
            'create' => CreateRek::route('/create'),
            'edit' => EditRek::route('/{record}/edit'),
        ];
    }
}
