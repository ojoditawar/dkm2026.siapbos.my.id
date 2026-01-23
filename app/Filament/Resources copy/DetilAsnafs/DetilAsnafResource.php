<?php

namespace App\Filament\Resources\DetilAsnafs;

use App\Filament\Resources\DetilAsnafs\Pages\CreateDetilAsnaf;
use App\Filament\Resources\DetilAsnafs\Pages\EditDetilAsnaf;
use App\Filament\Resources\DetilAsnafs\Pages\ListDetilAsnafs;
use App\Filament\Resources\DetilAsnafs\Pages\ViewDetilAsnaf;
use App\Filament\Resources\DetilAsnafs\Schemas\DetilAsnafForm;
use App\Filament\Resources\DetilAsnafs\Schemas\DetilAsnafInfolist;
use App\Filament\Resources\DetilAsnafs\Tables\DetilAsnafsTable;
use App\Models\DetilAsnaf;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DetilAsnafResource extends Resource
{
    protected static ?string $model = DetilAsnaf::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'RUH Penerima ZIS';

    public static function form(Schema $schema): Schema
    {
        return DetilAsnafForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DetilAsnafInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DetilAsnafsTable::configure($table);
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
            'index' => ListDetilAsnafs::route('/'),
            'create' => CreateDetilAsnaf::route('/create'),
            'view' => ViewDetilAsnaf::route('/{record}'),
            'edit' => EditDetilAsnaf::route('/{record}/edit'),
        ];
    }
}
