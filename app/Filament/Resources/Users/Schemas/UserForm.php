<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Select::make('masjid_id')
                    ->relationship('masjid', 'nama')
                    ->preload()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn(callable $set) => $set('bendahara_id', null)),
                Select::make('bendahara_id')
                    ->relationship(
                        name: 'bendahara',
                        titleAttribute: 'nama',
                        modifyQueryUsing: fn($query, callable $get) =>
                        $query->when(
                            $get('masjid_id'),
                            fn($q, $masjidId) =>
                            $q->where('masjid_id', $masjidId)
                        )
                    )
                    ->preload()
                    ->searchable()
                    ->disabled(fn(callable $get) => !$get('masjid_id')),
                // DateTimePicker::make('email_verified_at'),
                // Textarea::make('two_factor_secret')
                //     ->columnSpanFull(),
                // Textarea::make('two_factor_recovery_codes')
                //     ->columnSpanFull(),
                // DateTimePicker::make('two_factor_confirmed_at'),
            ]);
    }
}
