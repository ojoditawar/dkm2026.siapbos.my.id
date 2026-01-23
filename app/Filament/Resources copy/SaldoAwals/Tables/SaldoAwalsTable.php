<?php

namespace App\Filament\Resources\SaldoAwals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\Tahun;
use App\Models\Level1;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;

class SaldoAwalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun.tahun')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('akun1')
                    ->label('Akun')
                    ->formatStateUsing(fn($record) => $record->akun1()->first()?->nama ?? $record->akun1)
                    ->searchable(),
                TextColumn::make('level2.nama')
                    ->label('Kelompok Akun')
                    ->sortable(),
                TextColumn::make('level3.nama')
                    ->label('Jenis Akun')
                    ->sortable(),
                TextColumn::make('bank')
                    ->label('Bank')
                    ->searchable(),
                TextColumn::make('rekening')
                    ->label('No. Rekening')
                    ->searchable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah Saldo')
                    ->money('IDR')
                    ->sortable(),
                // TextColumn::make('keterangan')
                //     ->label('Keterangan')
                //     ->searchable()
                //     ->limit(50),
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
                SelectFilter::make('tahun_id')
                    ->label('Tahun')
                    ->options(Tahun::all()->pluck('tahun', 'id'))
                    ->preload(),
                SelectFilter::make('akun1')
                    ->label('Level 1')
                    ->options(Level1::all()->pluck('nama', 'akun1'))
                    ->preload(),
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
