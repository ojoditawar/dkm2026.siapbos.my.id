<?php

namespace App\Filament\Resources\SubReks\Tables;

use App\Filament\Resources\Rekenings\RekeningResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubReksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('kelompok', 'asc')
            ->columns([
                TextColumn::make('rek.nama')->label('Kode Akun')
                    ->searchable(),
                TextColumn::make('kelompok')->label('Kode Sub Akun')
                    ->searchable(),
                TextColumn::make('nama')->label('Nama Sub Akun')
                    ->searchable(),
                TextColumn::make('rekenings.nama')->label('Nama Rekening'),
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
                // Action::make('view')
                //     ->icon('heroicon-o-eye')
                //     ->url(fn($record) => RekeningResource::getUrl('index', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
