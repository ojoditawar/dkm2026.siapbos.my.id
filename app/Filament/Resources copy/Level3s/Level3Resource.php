<?php

namespace App\Filament\Resources\Level3s;

use App\Filament\Resources\Level3s\Pages\CreateLevel3;
use App\Filament\Resources\Level3s\Pages\EditLevel3;
use App\Filament\Resources\Level3s\Pages\ListLevel3s;
use App\Filament\Resources\Level3s\Pages\ViewLevel3;
use App\Filament\Resources\Level3s\Schemas\Level3Form;
use App\Filament\Resources\Level3s\Schemas\Level3Infolist;
use App\Filament\Resources\Level3s\Tables\Level3sTable;
use App\Models\Level3;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class Level3Resource extends Resource
{
    protected static ?string $model = Level3::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nama';
    // protected static string | UnitEnum | null $navigationGroup = 'XXXX';

    public static function form(Schema $schema): Schema
    {
        return Level3Form::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return Level3Infolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return Level3sTable::configure($table);
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
            'index' => ListLevel3s::route('/'),
            'create' => CreateLevel3::route('/create'),
            'view' => ViewLevel3::route('/{record}'),
            'edit' => EditLevel3::route('/{record}/edit'),
        ];
    }
}
