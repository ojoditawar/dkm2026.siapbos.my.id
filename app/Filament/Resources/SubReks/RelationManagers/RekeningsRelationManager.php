<?php

namespace App\Filament\Resources\SubReks\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RekeningsRelationManager extends RelationManager
{
    protected static string $relationship = 'rekenings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // rek_id, akun, kelompok will be auto-generated from SubRek relationship
                TextInput::make('jenis')
                    ->required()
                    ->maxLength(2),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('jenis', 'asc')
            ->recordTitleAttribute('nama')
            ->columns([
                // TextColumn::make('rek_id')
                //     ->numeric()
                //     ->sortable(),
                TextColumn::make('akun')
                    ->searchable(),
                TextColumn::make('kelompok')
                    ->searchable(),
                TextColumn::make('jenis')
                    // ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
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
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
