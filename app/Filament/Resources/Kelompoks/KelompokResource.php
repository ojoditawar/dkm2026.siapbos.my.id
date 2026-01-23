<?php

namespace App\Filament\Resources\Kelompoks;

use App\Filament\Resources\Kelompoks\Pages\CreateKelompok;
use App\Filament\Resources\Kelompoks\Pages\EditKelompok;
use App\Filament\Resources\Kelompoks\Pages\ListKelompoks;
use App\Filament\Resources\Kelompoks\Schemas\KelompokForm;
use App\Filament\Resources\Kelompoks\Tables\KelompoksTable;
use App\Models\Kelompok;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KelompokResource extends Resource
{
    protected static ?string $model = Kelompok::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'kode';

    public static function form(Schema $schema): Schema
    {
        return KelompokForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelompoksTable::configure($table);
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
            'index' => ListKelompoks::route('/'),
            'create' => CreateKelompok::route('/create'),
            'edit' => EditKelompok::route('/{record}/edit'),
        ];
    }
}
