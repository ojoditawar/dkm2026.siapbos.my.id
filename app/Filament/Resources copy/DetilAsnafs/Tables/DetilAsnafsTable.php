<?php

namespace App\Filament\Resources\DetilAsnafs\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DetilAsnafsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asnaf.nama')
                    ->label('Jenis Asnaf'),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('jenis')
                    ->formatStateUsing(function ($state) {
                        return $state === 'UMUM' ? 'UMUM' : 'Bea Siswa';
                    })
                    ->badge()
                    ->color(function ($state) {
                        return $state === 'UMUM' ? 'success' : 'primary';
                    }),
                TextColumn::make('alamat')
                    ->searchable(),
                TextColumn::make('hp')
                    ->searchable(),
                TextColumn::make('satuan')->label('Jumlah Santunan')
                    ->prefix('Rp ')
                    ->numeric()
                    ->searchable(),
                TextColumn::make('ktp')
                    ->searchable(),
                TextColumn::make('rekening')
                    ->searchable(),
                TextColumn::make('bank')
                    ->searchable(),
                TextColumn::make('foto')
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
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
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
