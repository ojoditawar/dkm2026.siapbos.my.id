<?php

namespace App\Filament\Resources\SalurZakats;

use App\Filament\Resources\SalurZakats\Pages\CreateSalurZakat;
use App\Filament\Resources\SalurZakats\Pages\EditSalurZakat;
use App\Filament\Resources\SalurZakats\Pages\ListSalurZakats;
use App\Filament\Resources\SalurZakats\Pages\ViewSalurZakat;
use App\Filament\Resources\SalurZakats\Schemas\SalurZakatForm;
use App\Filament\Resources\SalurZakats\Schemas\SalurZakatInfolist;
use App\Filament\Resources\SalurZakats\Tables\SalurZakatsTable;
use App\Models\SalurZakat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalurZakatResource extends Resource
{
    protected static ?string $model = SalurZakat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'RUH Daftar Penyaluran ZIS';

    public static function form(Schema $schema): Schema
    {
        return SalurZakatForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SalurZakatInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalurZakatsTable::configure($table);
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
            'index' => ListSalurZakats::route('/'),
            'create' => CreateSalurZakat::route('/create'),
            'view' => ViewSalurZakat::route('/{record}'),
            'edit' => EditSalurZakat::route('/{record}/edit'),
        ];
    }
}
