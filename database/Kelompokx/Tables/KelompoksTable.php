<?php

namespace App\Filament\Resources\Kelompoks\Tables;

use App\Models\Akun;
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
            ->columns([
                TextColumn::make('kode')
                    ->label('Akun'),
                TextColumn::make('kelompok')
                    ->searchable(),
                TextColumn::make('nama')
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

//  ->formatStateUsing(
//                     fn($record) =>
//                     $record->akun
//                         ? $record->akun->kode . '-' . str_pad($record->kelompok, 2, '0', STR_PAD_LEFT)
//                         : '-'
//                 ) -> untuk mengganti tampilan label di tabel

            // ->modifyQueryUsing(
            //     fn($query) => $query
            //         ->select('kelompok.*')
            //     // ->join('akun', 'kelompok.kode', '=', 'akun.kode')
            //     // ->orderBy('akun.kode', 'ASC')
            //     // ->orderBy('kelompok.kelompok', 'ASC')
            // )