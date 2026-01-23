<?php

namespace App\Filament\Resources\Penguruses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PengurusForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun')
                    ->default(now()->format('Y'))
                    ->columnSpan('full')
                    ->required(),
                Select::make('struktur_id')
                    ->relationship('struktur', 'nama')
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('nama')
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('keterangan')->columnSpan('full'),
                FileUpload::make('foto'),
                Toggle::make('status')
            ]);
    }
}
