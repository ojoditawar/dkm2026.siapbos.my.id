<?php

namespace App\Filament\Resources\SubDanas;

use App\Filament\Resources\SubDanas\Pages\CreateSubDana;
use App\Filament\Resources\SubDanas\Pages\EditSubDana;
use App\Filament\Resources\SubDanas\Pages\ListSubDanas;
use App\Filament\Resources\SubDanas\Pages\ViewSubDana;
use App\Filament\Resources\SubDanas\Schemas\SubDanaForm;
use App\Filament\Resources\SubDanas\Schemas\SubDanaInfolist;
use App\Filament\Resources\SubDanas\Tables\SubDanasTable;
use App\Models\SubDana;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubDanaResource extends Resource
{
    protected static ?string $model = SubDana::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return SubDanaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SubDanaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubDanasTable::configure($table);
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
            'index' => ListSubDanas::route('/'),
            'create' => CreateSubDana::route('/create'),
            'view' => ViewSubDana::route('/{record}'),
            'edit' => EditSubDana::route('/{record}/edit'),
        ];
    }
}
