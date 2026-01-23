<?php

namespace App\Filament\Resources\Pagus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PagusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun'),
                TextColumn::make('rek.nama')->label('Akun')
                    ->searchable(),
                TextColumn::make('subrek.nama')->label('Kelompok Akun')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reken.nama')->label('Jenis Akun')
                    ->sortable(),
                TextColumn::make('total_anggaran')
                    ->label('Total Anggaran')
                    ->getStateUsing(function ($record) {
                        return $record->paguDetils()->sum('total');
                    })
                    ->numeric()
                    ->money('IDR')
                    ->sortable(false),
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
