<?php

namespace App\Filament\Resources\Level2s;

use App\Filament\Resources\Level2s\Pages\CreateLevel2;
use App\Filament\Resources\Level2s\Pages\EditLevel2;
use App\Filament\Resources\Level2s\Pages\ListLevel2s;
use App\Filament\Resources\Level2s\Pages\ViewLevel2;
use App\Filament\Resources\Level2s\RelationManagers\Level3RelationManager;
use App\Filament\Resources\Level2s\Schemas\Level2Form;
use App\Filament\Resources\Level2s\Schemas\Level2Infolist;
use App\Filament\Resources\Level2s\Tables\Level2sTable;
use App\Models\Level2;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class Level2Resource extends Resource
{
    protected static ?string $model = Level2::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nama';
    protected static ?string $navigationLabel = 'Referensi Kelompok Akun';

    public static function form(Schema $schema): Schema
    {
        return Level2Form::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return Level2Infolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Level2sTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            Level3RelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLevel2s::route('/'),
            'create' => CreateLevel2::route('/create'),
            'view' => ViewLevel2::route('/{record}'),
            'edit' => EditLevel2::route('/{record}/edit'),
        ];
    }
}
