<?php

namespace App\Filament\Resources\Level1s;

use App\Filament\Resources\Level1s\Pages\CreateLevel1;
use App\Filament\Resources\Level1s\Pages\EditLevel1;
use App\Filament\Resources\Level1s\Pages\ListLevel1s;
use App\Filament\Resources\Level1s\Pages\ViewLevel1;
use App\Filament\Resources\Level1s\Schemas\Level1Form;
use App\Filament\Resources\Level1s\Schemas\Level1Infolist;
use App\Filament\Resources\Level1s\Tables\Level1sTable;
use App\Models\Level1;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Level1s\RelationManagers;
use App\Filament\Resources\Level1s\RelationManagers\Level2RelationManager;

class Level1Resource extends Resource
{
    protected static ?string $model = Level1::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nama';
    protected static ?string $navigationLabel = 'Referensi Akun';

    public static function form(Schema $schema): Schema
    {
        return Level1Form::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return Level1Infolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Level1sTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            Level2RelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLevel1s::route('/'),
            'create' => CreateLevel1::route('/create'),
            'view' => ViewLevel1::route('/{record}'),
            'edit' => EditLevel1::route('/{record}/edit'),
        ];
    }
}
