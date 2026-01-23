<?php

namespace App\Filament\Resources\Rekenings;

use App\Filament\Resources\Rekenings\Pages\CreateRekening;
use App\Filament\Resources\Rekenings\Pages\EditRekening;
use App\Filament\Resources\Rekenings\Pages\ListRekenings;
use App\Filament\Resources\Rekenings\Schemas\RekeningForm;
use App\Filament\Resources\Rekenings\Tables\RekeningsTable;
use App\Models\Rekening;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RekeningResource extends Resource
{
    protected static ?string $model = Rekening::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return RekeningForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RekeningsTable::configure($table);
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
            'index' => ListRekenings::route('/'),
            'create' => CreateRekening::route('/create'),
            'edit' => EditRekening::route('/{record}/edit'),
        ];
    }
}
