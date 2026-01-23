<?php

namespace App\Filament\Resources\Anggarans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnggaransTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tahun.tahun')
                    ->sortable(),
                TextColumn::make('level1.nama')
                    ->searchable(),
                TextColumn::make('level2.nama')
                    ->searchable(),
                TextColumn::make('level3.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sumber_dana.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sub_dana.nama')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah')->label('Pagu')
                    ->numeric()
                    ->default(0)
                    ->formatStateUsing(function ($state) {
                        if (!$state) return 'Rp 0';
                        return 'Rp ' . number_format((float) $state, 0, '.', ',');
                    })
                    ->sortable(),
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
                ViewAction::make(),
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

                            // ->label('Rincian Anggaran')
                            // ->schema([
                            //     Textarea::make('uraian')
                            //         ->required()
                            //         ->columnSpanFull(),
                            //     TextInput::make('jumlah')
                            //         ->mask(RawJs::make('$money($input)'))
                            //         ->required()
                            //         ->stripCharacters(',') // Removes commas before saving
                            //         ->numeric() // Ensures only numeric input
                            //         ->prefix('Rp.'), // Adds a currency symbol prefix
                            //     TextInput::make('keterangan')->columnSpanFull(),
                            // ])
                            // ->columnSpanFull(),
