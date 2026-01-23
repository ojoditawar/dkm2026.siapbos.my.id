<?php

namespace App\Filament\Resources\Tahuns\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Filament\Forms\Components\TextInput\Mask;

class TahunForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tahun')
                    ->numeric()
                    // ->mask(RawJs::make('$money($input)'))
                    // ->afterStateHydrated(
                    //     fn($component, $state) =>
                    //     $component->state(number_format($state, 2, '.', ','))
                    // )
                    // ->dehydrateStateUsing(
                    //     fn($state) =>
                    //     str_replace([',', '.'], ['', '.'], $state)
                    // )
                    ->required(),
                TextInput::make('keterangan'),
                Toggle::make('aktif')
                    ->required(),
            ]);
    }
}
