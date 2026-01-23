<?php

namespace App\Filament\Resources\Anggarans;

use App\Filament\Resources\Anggarans\Pages\CreateAnggaran;
use App\Filament\Resources\Anggarans\Pages\EditAnggaran;
use App\Filament\Resources\Anggarans\Pages\ListAnggarans;
use App\Filament\Resources\Anggarans\Pages\ViewAnggaran;
use App\Filament\Resources\Anggarans\Schemas\AnggaranForm;
use App\Filament\Resources\Anggarans\Schemas\AnggaranInfolist;
use App\Filament\Resources\Anggarans\Tables\AnggaransTable;
use App\Models\Anggaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnggaranResource extends Resource
{
    protected static ?string $model = Anggaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tahun';

    public static function form(Schema $schema): Schema
    {
        return AnggaranForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AnggaranInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnggaransTable::configure($table);
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
            'index' => ListAnggarans::route('/'),
            'create' => CreateAnggaran::route('/create'),
            'view' => ViewAnggaran::route('/{record}'),
            'edit' => EditAnggaran::route('/{record}/edit'),
        ];
    }
}
