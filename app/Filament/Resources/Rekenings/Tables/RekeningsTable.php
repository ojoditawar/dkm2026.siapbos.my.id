<?php

namespace App\Filament\Resources\Rekenings\Tables;

use App\Models\Rekening;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RekeningsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('jenis', 'asc')
            ->columns([
                TextColumn::make('akun')->label('Nama Akun')
                    ->formatStateUsing(fn(Rekening $record): string => $record->rek->kode . ' - ' . $record->rek->nama)
                    ->searchable(),
                TextColumn::make('kelompok')->label('Nama Sub Akun')
                    ->formatStateUsing(fn(Rekening $record): string => $record->kelompok . ' -> ' . $record->subRek->nama)
                    ->searchable(),
                TextColumn::make('jenis')->label('Jenis')->label('Kode Jenis Akun')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')->label('Nama Jenis Akun')
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
