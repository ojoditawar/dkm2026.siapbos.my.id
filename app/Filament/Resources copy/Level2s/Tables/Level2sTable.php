<?php

namespace App\Filament\Resources\Level2s\Tables;

use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class Level2sTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('akun1', 'asc')
            ->columns([
                TextColumn::make('level1.nama')->label('Nama Akun')
                    ->color('primary')
                    ->icon(LucideIcon::Briefcase)
                    // ->sortable(query: function ($query, string $direction): void {
                    //     $query->orderBy('akun1', $direction);
                    // })
                    ->searchable(),
                // TextColumn::make('akun2')
                //     ->searchable(),
                TextColumn::make('nama')->label('Kelompok Akun')
                    ->searchable(),
                // TextColumn::make('slug')
                //     ->searchable(),
                TextColumn::make('keterangan')->html()
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
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
