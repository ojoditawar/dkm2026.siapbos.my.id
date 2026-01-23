<?php

namespace App\Filament\Resources\Buktis\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BuktisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor')
                    ->searchable(),
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('penerima')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('uraian'),
                TextColumn::make('jumlah')
                    ->numeric(),
                // ->currency('IDR'),
                TextColumn::make('keterangan'),
                TextColumn::make('file_bukti'),
                TextColumn::make('danaLevel3.nama')
                    ->label('Sumber Dana')
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
                ViewAction::make(),
                EditAction::make(),
                Action::make('cetak')
                    ->label('Cetak Kuitansi')
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('buktis.print', $record))
                    ->openUrlInNewTab()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
