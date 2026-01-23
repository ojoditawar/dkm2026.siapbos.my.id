<?php

namespace App\Filament\Resources\Level1s\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class Level1sTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('akun1')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('slug')
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
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    //     // Action::make('cetak')
                    //     //     ->label('Cetak')
                    //     //     ->icon('heroicon-o-printer')
                    //     //     ->url(fn($record) => route('level1.print', $record)) // route untuk print
                    //     //     ->openUrlInNewTab(), // buka di tab baru
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
