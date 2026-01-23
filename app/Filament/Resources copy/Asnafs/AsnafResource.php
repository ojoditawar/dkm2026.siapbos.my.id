<?php

namespace App\Filament\Resources\Asnafs;

use App\Filament\Resources\Asnafs\Pages\CreateAsnaf;
use App\Filament\Resources\Asnafs\Pages\EditAsnaf;
use App\Filament\Resources\Asnafs\Pages\ListAsnafs;
use App\Filament\Resources\Asnafs\Pages\ViewAsnaf;
use App\Filament\Resources\Asnafs\Schemas\AsnafForm;
use App\Filament\Resources\Asnafs\Schemas\AsnafInfolist;
use App\Filament\Resources\Asnafs\Tables\AsnafsTable;
use App\Models\Asnaf;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AsnafResource extends Resource
{
    protected static ?string $model = Asnaf::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Nama';
    protected static ?string $navigationLabel = 'Ref. Jenis Asnaf';

    public static function form(Schema $schema): Schema
    {
        return AsnafForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AsnafInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AsnafsTable::configure($table);
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
            'index' => ListAsnafs::route('/'),
            'create' => CreateAsnaf::route('/create'),
            'view' => ViewAsnaf::route('/{record}'),
            'edit' => EditAsnaf::route('/{record}/edit'),
        ];
    }
}
