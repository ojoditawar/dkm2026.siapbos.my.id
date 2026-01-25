<?php

namespace App\Filament\Resources\Masjids\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class MasjidForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->label('Informasi Masjid')
                    ->schema([
                        TextInput::make('nama'),
                        TextInput::make('alamat'),
                        FileUpload::make('image')
                            ->image(),
                    ])->columnSpanFull(),

                Section::make()
                    ->label('Informasi Bendahara')
                    ->schema([
                        TableRepeater::make('bendaharas')
                            ->label('Informasi Bendahara')
                            ->relationship()
                            ->reorderable()
                            ->cloneable()
                            ->collapsible()
                            ->colStyles([
                                'bp' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 160px;',
                                'nama' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 700px;',
                                'keterangan' => 'text-align: center; background-color: #ded5a4ff; color: #3912d4ff; width: 800px;',
                            ])
                            ->schema([
                                TextInput::make('bp')->maxLength(2)->required(),
                                TextInput::make('nama')->required(),
                                TextInput::make('keterangan')->required(),
                            ])->columnSpanFull()
                    ])->columnSpanFull()


            ]);
    }
}
