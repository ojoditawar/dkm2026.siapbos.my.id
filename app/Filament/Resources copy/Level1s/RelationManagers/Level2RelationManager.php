<?php

namespace App\Filament\Resources\Level1s\RelationManagers;

use App\Models\Level1;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class Level2RelationManager extends RelationManager
{
    protected static string $relationship = 'level2s';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('akun1')
                //     ->options(function () {
                //         return Level1::all()->pluck('nama', 'akun1');
                //     })
                //     ->default(fn() => session('level2_akun1')) // isi awal dari session kalau ada
                //     ->live()
                //     ->afterStateUpdated(function ($state) {
                //         // setiap kali user ganti akun1, simpan ke session
                //         session(['level2_akun1' => $state]);
                //     })
                //     ->required(),
                TextInput::make('akun2')->label('Kode Akun Level 2')
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
                RichEditor::make('keterangan')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Nama')
            ->columns([
                TextColumn::make('level1.nama')
                    ->searchable(),
                TextColumn::make('akun2')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->html(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
