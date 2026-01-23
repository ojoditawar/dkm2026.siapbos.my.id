<?php

namespace App\Filament\Resources\Reks\RelationManagers;

use App\Filament\Resources\SubReks\SubRekResource;
use Filament\Actions\Action;
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

class SubRekRelationManager extends RelationManager
{
    protected static string $relationship = 'subRek';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('kode')
                //     ->maxLength(1),
                TextInput::make('kelompok')
                    ->maxLength(4),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('kode')->label('Kode Akun')
                    ->searchable(),
                TextColumn::make('kelompok')->label('Kode Sub Akun')
                    ->searchable(),
                TextColumn::make('nama')->label('Nama Sub Akun')
                    ->searchable(),
            ])
            // ->defaultSort('akun', 'asc') // <--- TAMBAHKAN INI agar tidak mencari 'id'
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),


            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
