<?php

namespace App\Filament\Resources\Anggarans\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class AnggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun.tahun')
                    ->sortable(),
                TextColumn::make('level1.nama')->label('Akun')
                    ->searchable(),
                TextColumn::make('level2.nama')->label('Kelompok Akun')
                    ->searchable(),
                TextColumn::make('level3.nama')->label('Jenis Akun')
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sumber_dana.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sub_dana.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah')->label('Jumlah Pagu')
                    ->getStateUsing(function ($record) {
                        // Hitung total dari detail items yang dikelompokkan berdasarkan level1, level2, level3
                        $totalPagu = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $jumlah = (float) ($detailItem->jumlah ?? 0);
                            $harga = (float) ($detailItem->harga ?? 0);
                            $totalPagu += $jumlah * $harga;
                        }
                        return $totalPagu;
                    })
                    ->formatStateUsing(function ($state) {
                        return number_format((float) $state, 0, '.', ',');
                    })
                    ->sortable(query: function ($query, $direction) {
                        return $query->withSum(['detailItems as total_pagu'], DB::raw('jumlah * harga'))
                            ->orderBy('total_pagu', $direction);
                    }),
                TextColumn::make('realisasi')
                    ->label('Realisasi')
                    ->getStateUsing(function ($record) {
                        // Hitung total realisasi dari bukti-bukti yang terkait dengan anggaran detail items
                        $totalRealisasi = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $totalRealisasi += 0;
                            // $totalRealisasi += $detailItem->buktis()->sum('jumlah');
                        }
                        return $totalRealisasi;
                    })
                    ->formatStateUsing(function ($state) {
                        return  number_format((float) $state, 0, '.', ',');
                        // return 'Rp ' . number_format((float) $state, 0, '.', ',');
                    })
                    ->sortable(query: function ($query, $direction) {
                        return $query->withSum(['detailItems.buktis as total_realisasi'], 'jumlah')
                            ->orderBy('total_realisasi', $direction);
                    }),
                TextColumn::make('persentase_realisasi')
                    ->label('% Realisasi')
                    ->getStateUsing(function ($record) {
                        // Hitung pagu dari detail items (sama seperti kolom Jumlah Pagu)
                        $pagu = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $jumlah = (float) ($detailItem->jumlah ?? 0);
                            $harga = (float) ($detailItem->harga ?? 0);
                            $pagu += $jumlah * $harga;
                        }

                        if ($pagu == 0) return 0;

                        $totalRealisasi = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $totalRealisasi += 0;
                            // $totalRealisasi += $detailItem->buktis()->sum('jumlah');
                        }

                        return round(($totalRealisasi / $pagu) * 100, 2);
                    })
                    ->formatStateUsing(function ($state) {
                        $color = $state >= 100 ? 'success' : ($state >= 75 ? 'warning' : 'danger');
                        return "<span class='text-{$color}-600 font-semibold'>{$state}%</span>";
                    })
                    ->html()
                    ->sortable(false),
                TextColumn::make('sisa_anggaran')
                    ->label('Sisa Anggaran')
                    ->getStateUsing(function ($record) {
                        // Hitung pagu dari detail items (sama seperti kolom Jumlah Pagu)
                        $pagu = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $jumlah = (float) ($detailItem->jumlah ?? 0);
                            $harga = (float) ($detailItem->harga ?? 0);
                            $pagu += $jumlah * $harga;
                        }

                        $totalRealisasi = 0;
                        foreach ($record->detailItems as $detailItem) {
                            $totalRealisasi += 0;
                            // $totalRealisasi += $detailItem->buktis()->sum('jumlah');
                        }
                        return $pagu - $totalRealisasi;
                    })
                    ->formatStateUsing(function ($state) {
                        $color = $state < 0 ? 'danger' : 'success';
                        return "<span class='text-{$color}-600'>Rp " . number_format((float) $state, 0, '.', ',') . "</span>";
                    })
                    ->html()
                    ->sortable(false),
                // TextColumn::make('keterangan')
                //     ->searchable(),
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
