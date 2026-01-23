<?php

namespace App\Filament\Resources\Strukturs\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Malzariey\FilamentLexicalEditor\LexicalEditor;


class TugasRelationManager extends RelationManager
{
    protected static string $relationship = 'Tugas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                LexicalEditor::make('uraian')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('uraian')
            ->columns([
                TextColumn::make('uraian')->label('Uraian Tugas Pengurus DKM')
                    ->html()
                    ->searchable(),
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
                DeleteAction::make()
                    ->modalHeading('Hapus Data Sumber Dana Terpilih')
                    ->modalDescription('Apakah Anda yakin ingin menghapus semua data yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus Semua')
                    ->modalCancelActionLabel('Batal'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make()
                        ->modalHeading('Hapus Data Sumber Dana Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua data yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus Semua')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ]);
    }
}
