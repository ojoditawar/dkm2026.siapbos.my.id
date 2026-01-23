<?php

namespace App\Filament\Resources\SalurZakats\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class SalurZakatsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('nomor')
                    ->sortable(),
                TextColumn::make('id')
                    ->label('Lampiran')
                    ->formatStateUsing(fn() => 'Cetak Daftar')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-printer')
                    ->iconPosition('after')
                    ->url(fn($record) => route('salur-zakat.print', $record->id))
                    ->openUrlInNewTab(),
                TextColumn::make('jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'UMUM' => 'info',
                        'BEASISWA' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('details_sum_satuan')
                    ->label('Jumlah')
                    ->sum('details', 'satuan')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state ?? 0, 0, ',', '.')),

                // Jadi dengan relasi, kita dapat mengambil data dari detail dengan cara praktis
                //  ->sum('details', 'satuan') details=nama relasi di model

                // SELECT 
                //     salur_zakats.*,
                //     SUM(salur_zakat_details.satuan) as details_sum_satuan
                // FROM salur_zakats
                // LEFT JOIN salur_zakat_details ON salur_zakats.id = salur_zakat_details.salur_zakat_id
                // GROUP BY salur_zakats.id

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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
