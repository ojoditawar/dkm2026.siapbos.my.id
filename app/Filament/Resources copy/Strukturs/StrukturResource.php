<?php

namespace App\Filament\Resources\Strukturs;

use App\Filament\Resources\Strukturs\Pages\CreateStruktur;
use App\Filament\Resources\Strukturs\Pages\EditStruktur;
use App\Filament\Resources\Strukturs\Pages\ListStrukturs;
use App\Filament\Resources\Strukturs\Pages\ViewStruktur;
use App\Filament\Resources\Strukturs\RelationManagers\TugasRelationManager;
use App\Filament\Resources\Strukturs\Schemas\StrukturForm;
use App\Filament\Resources\Strukturs\Schemas\StrukturInfolist;
use App\Filament\Resources\Strukturs\Tables\StruktursTable;
use App\Models\Struktur;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StrukturResource extends Resource
{
    protected static ?string $model = Struktur::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama';
    protected static ?string $navigationLabel = 'Referensi Struktur DKM';

    public static function form(Schema $schema): Schema
    {
        return StrukturForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StrukturInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StruktursTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'tugas' => TugasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStrukturs::route('/'),
            'create' => CreateStruktur::route('/create'),
            'view' => ViewStruktur::route('/{record}'),
            'edit' => EditStruktur::route('/{record}/edit'),
        ];
    }
}
