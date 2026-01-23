<?php

namespace App\Filament\Resources\Kelompoks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelompoksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with('akun')->orderBy('kode')->orderBy('kelompok'))
            ->columns([
                TextColumn::make('kode')
                    ->label('Akun')
                    ->formatStateUsing(fn($record) => $record->akun ? $record->akun->kode . ' - ' . $record->akun->nama : '-')
                    ->searchable(),
                TextColumn::make('kelompok')
                    ->formatStateUsing(fn($record) => $record->akun ? $record->akun->kode . '.' . $record->kelompok : '-')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Kelompok')
                    ->formatStateUsing(fn($record) => $record->akun ? $record->nama : '-')
                    // ->formatStateUsing(fn($record) => $record->akun ? $record->akun->kode . '-' . $record->kelompok . ' - ' . $record->akun->nama : $record->nama)
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            // ->defaultSort('kode', 'asc')
            // // ->defaultSort('kelompok', 'asc')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
