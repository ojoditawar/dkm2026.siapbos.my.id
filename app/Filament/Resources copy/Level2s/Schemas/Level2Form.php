<?php

namespace App\Filament\Resources\Level2s\Schemas;

use App\Models\Level1;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;

class Level2Form
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('akun1')
                    ->prefixIcon(LucideIcon::Briefcase)
                    ->options(function () {
                        return Level1::all()->pluck('nama', 'akun1');
                    })
                    ->default(fn() => session('level2_akun1')) // isi awal dari session kalau ada
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        // setiap kali user ganti akun1, simpan ke session
                        session(['level2_akun1' => $state]);
                    })
                    ->required(),
                TextInput::make('akun2')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('nama')
                    ->columnSpan('full')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->columnSpan('full')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->hint('Otomatis dibuat dari nama'),
                Textarea::make('keterangan')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
