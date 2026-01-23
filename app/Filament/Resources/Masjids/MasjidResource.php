<?php

namespace App\Filament\Resources\Masjids;

use App\Filament\Resources\Masjids\Pages\CreateMasjid;
use App\Filament\Resources\Masjids\Pages\EditMasjid;
use App\Filament\Resources\Masjids\Pages\ListMasjids;
use App\Filament\Resources\Masjids\Schemas\MasjidForm;
use App\Filament\Resources\Masjids\Tables\MasjidsTable;
use App\Models\Masjid;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MasjidResource extends Resource
{
    protected static ?string $model = Masjid::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return MasjidForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MasjidsTable::configure($table);
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
            'index' => ListMasjids::route('/'),
            'create' => CreateMasjid::route('/create'),
            'edit' => EditMasjid::route('/{record}/edit'),
        ];
    }
}
