<?php

namespace App\Filament\Resources\SaldoAwals;

use App\Filament\Resources\SaldoAwals\Pages\CreateSaldoAwal;
use App\Filament\Resources\SaldoAwals\Pages\EditSaldoAwal;
use App\Filament\Resources\SaldoAwals\Pages\ListSaldoAwals;
use App\Filament\Resources\SaldoAwals\Pages\ViewSaldoAwal;
use App\Filament\Resources\SaldoAwals\Schemas\SaldoAwalForm;
use App\Filament\Resources\SaldoAwals\Schemas\SaldoAwalInfolist;
use App\Filament\Resources\SaldoAwals\Tables\SaldoAwalsTable;
use App\Models\Saldo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SaldoAwalResource extends Resource
{
    protected static ?string $model = Saldo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    protected static ?string $navigationLabel = 'RUH Saldo Kas';

    public static function form(Schema $schema): Schema
    {
        return SaldoAwalForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SaldoAwalInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SaldoAwalsTable::configure($table);
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
            'index' => ListSaldoAwals::route('/'),
            'create' => CreateSaldoAwal::route('/create'),
            'view' => ViewSaldoAwal::route('/{record}'),
            'edit' => EditSaldoAwal::route('/{record}/edit'),
        ];
    }
}
