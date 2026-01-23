<?php

namespace App\Filament\Resources\SubDanas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubDanasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                return $query->orderBy('sumber', 'asc')->orderBy('sub', 'asc');
            })
            ->columns([
                // TextColumn::make('sumber')
                //     ->label('Kode Sumber')
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('sumberDana.nama')
                    ->label('Nama Sumber Dana')
                    ->searchable(),
                TextColumn::make('sub')
                    ->label('Kode Sub')
                    // ->sortable()
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
