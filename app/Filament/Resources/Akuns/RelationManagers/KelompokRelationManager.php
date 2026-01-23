<?php

namespace App\Filament\Resources\Akuns\RelationManagers;

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

class KelompokRelationManager extends RelationManager
{
    protected static string $relationship = 'kelompoks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kelompok')
                    ->label('Kelompok')
                    ->required()
                    ->maxLength(2),
                TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('akun')
            ->columns([
                TextColumn::make('akun.nama'),
                TextColumn::make('kelompok'),
                TextColumn::make('nama'),
                TextColumn::make('keterangan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
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
