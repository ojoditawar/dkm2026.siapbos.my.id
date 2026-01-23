<?php

namespace App\Filament\Resources\Buktis;

use App\Filament\Resources\Buktis\Pages\CreateBukti;
use App\Filament\Resources\Buktis\Pages\EditBukti;
use App\Filament\Resources\Buktis\Pages\ListBuktis;
use App\Filament\Resources\Buktis\Pages\ViewBukti;
use App\Filament\Resources\Buktis\Schemas\BuktiForm;
use App\Filament\Resources\Buktis\Schemas\BuktiInfolist;
use App\Filament\Resources\Buktis\Tables\BuktisTable;
use App\Models\Bukti;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BuktiResource extends Resource
{
    protected static ?string $model = Bukti::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'Kuitansi';

    public static function form(Schema $schema): Schema
    {
        return BuktiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BuktiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BuktisTable::configure($table);
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
            'index' => ListBuktis::route('/'),
            'create' => CreateBukti::route('/create'),
            'view' => ViewBukti::route('/{record}'),
            'edit' => EditBukti::route('/{record}/edit'),
        ];
    }
}
