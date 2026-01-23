<?php

namespace App\Filament\Resources\Tahuns;

use App\Filament\Resources\Tahuns\Pages\CreateTahun;
use App\Filament\Resources\Tahuns\Pages\EditTahun;
use App\Filament\Resources\Tahuns\Pages\ListTahuns;
use App\Filament\Resources\Tahuns\Pages\ViewTahun;
use App\Filament\Resources\Tahuns\Schemas\TahunForm;
use App\Filament\Resources\Tahuns\Schemas\TahunInfolist;
use App\Filament\Resources\Tahuns\Tables\TahunsTable;
use App\Models\Tahun;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TahunResource extends Resource
{
    protected static ?string $model = Tahun::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    // protected static ?string $navigationGroup = 'Management Admin';

    protected static ?string $recordTitleAttribute = 'tahun';

    protected static ?string $navigationLabel = 'Seting Tahun';



    // protected static string | UnitEnum | null $navigationGroup = 'XXXX';

    // protected static ?int $navigationSort = 2;



    public static function form(Schema $schema): Schema
    {
        return TahunForm::configure($schema);
    }

    // public static function infolist(Schema $schema): Schema
    // {
    //     // return TahunInfolist::configure($schema);
    // }

    public static function table(Table $table): Table
    {
        return TahunsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTahuns::route('/'),
            'create' => CreateTahun::route('/create'),
            // 'view' => ViewTahun::route('/{record}'),
            'edit' => EditTahun::route('/{record}/edit'),
        ];
    }
}
