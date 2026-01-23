<?php

namespace App\Filament\Resources\Jamaahs;

use App\Filament\Resources\Jamaahs\Pages\CreateJamaah;
use App\Filament\Resources\Jamaahs\Pages\EditJamaah;
use App\Filament\Resources\Jamaahs\Pages\ListJamaahs;
use App\Filament\Resources\Jamaahs\Pages\ViewJamaah;
use App\Filament\Resources\Jamaahs\Schemas\JamaahForm;
use App\Filament\Resources\Jamaahs\Schemas\JamaahInfolist;
use App\Filament\Resources\Jamaahs\Tables\JamaahsTable;
use App\Models\Jamaah;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class JamaahResource extends Resource
{
    protected static ?string $model = Jamaah::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nama';
    protected static ?string $navigationLabel = 'RUH Jamaah Masjid';

    public static function form(Schema $schema): Schema
    {
        return JamaahForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return JamaahInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JamaahsTable::configure($table);
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
            'index' => ListJamaahs::route('/'),
            'create' => CreateJamaah::route('/create'),
            'view' => ViewJamaah::route('/{record}'),
            'edit' => EditJamaah::route('/{record}/edit'),
        ];
    }
}
