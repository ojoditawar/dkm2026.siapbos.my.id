<?php

namespace App\Filament\Resources\SumberDanas;

use App\Filament\Resources\SumberDanas\Pages\CreateSumberDana;
use App\Filament\Resources\SumberDanas\Pages\EditSumberDana;
use App\Filament\Resources\SumberDanas\Pages\ListSumberDanas;
use App\Filament\Resources\SumberDanas\Pages\ViewSumberDana;
use App\Filament\Resources\SumberDanas\RelationManagers\SubDanaRelationManager;
use App\Filament\Resources\SumberDanas\Schemas\SumberDanaForm;
use App\Filament\Resources\SumberDanas\Schemas\SumberDanaInfolist;
use App\Filament\Resources\SumberDanas\Tables\SumberDanasTable;
use App\Models\SumberDana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SumberDanaResource extends Resource
{
    protected static ?string $model = SumberDana::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Referensi Sumber Kas';

    public static function form(Schema $schema): Schema
    {
        return SumberDanaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SumberDanaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SumberDanasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'subDanas' => SubDanaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSumberDanas::route('/'),
            'create' => CreateSumberDana::route('/create'),
            'view' => ViewSumberDana::route('/{record}'),
            'edit' => EditSumberDana::route('/{record}/edit'),
        ];
    }
}
