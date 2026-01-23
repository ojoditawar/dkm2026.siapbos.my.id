<?php

namespace App\Filament\Resources\Jamaahs\Schemas;

use App\Enums\JenisPekerjaan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use emmanpbarrameda\FilamentTakePictureField\Forms\Components\TakePicture;

class JamaahForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
                TextInput::make('telpon')
                    ->label('Nomor Telepon')
                    ->numeric()
                    ->rules(['numeric', 'digits_between:10,15'])
                    ->validationMessages([
                        'numeric' => 'Nomor telepon hanya boleh berisi angka.',
                        'digits_between' => 'Nomor telepon harus antara 10-15 digit.',
                    ]),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->rules(['email:rfc,dns'])
                    ->validationMessages([
                        'email' => 'Format email tidak valid.',
                        'unique' => 'Email sudah digunakan.',
                        'required' => 'Email wajib diisi.',
                    ])
                    ->required(),
                Select::make('pekerjaan')
                    ->label('Jenis Pekerjaan')
                    ->options(JenisPekerjaan::getOptions()),
                // Select::make('pekerjaan')
                //     ->options(['PNS' => 'P n s', 'Swasta' => 'Swasta', 'Wirausaha' => 'Wirausaha', 'Pensiunan' => 'Pensiunan'])
                //     ->required(),
                // ToggleButtons::make('status')
                //     ->options([
                //         'Aktif' => 'Aktif',
                //         'Tidak Aktif' => 'Tidak Aktif',
                //     ])
                Toggle::make('status')
                    ->default(true)
                    ->required(),
                TakePicture::make('foto')
                    ->disk('public')
                    ->directory('uploads/jamaahs')
                    ->visibility('public')
                    ->useModal(true)
                    ->showCameraSelector(true)
                    ->aspect('16:9')
                    ->imageQuality(80),
                TextInput::make('keterangan'),
            ]);
    }
}
