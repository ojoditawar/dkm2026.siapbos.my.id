<?php

namespace App\Filament\Resources\Pagus;

use App\Filament\Resources\Pagus\Pages\CreatePagu;
use App\Filament\Resources\Pagus\Pages\EditPagu;
use App\Filament\Resources\Pagus\Pages\ListPagus;
use App\Filament\Resources\Pagus\Schemas\PaguForm;
use App\Filament\Resources\Pagus\Tables\PagusTable;
use App\Models\Pagu;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PaguResource extends Resource
{
    protected static ?string $model = Pagu::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return PaguForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagusTable::configure($table);
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
            'index' => ListPagus::route('/'),
            'create' => CreatePagu::route('/create'),
            'edit' => EditPagu::route('/{record}/edit'),
        ];
    }
}
