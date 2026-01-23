<?php

namespace App\Filament\Resources\Level2s\RelationManagers;

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
use Illuminate\Support\Str;
use Webbingbrasil\FilamentCopyActions\Tables\CopyableTextColumn;

class Level3RelationManager extends RelationManager
{
    protected static string $relationship = 'level3s';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('akun3')
                    ->columnSpan('full')
                    ->required(),
                TextInput::make('nama')
                    ->columnSpan('full')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $state, $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->columnSpan('full')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->hint('Otomatis dibuat dari nama'),
                TextInput::make('keterangan')
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Nama')
            ->columns([
                TextColumn::make('level2.level1.nama')->label('Nama Akun')
                    ->searchable(),
                TextColumn::make('level2.nama')->label('Kelompok Akun')
                    ->searchable(),
                TextColumn::make('akun3')->label('Jenis Akun')
                    ->searchable(),
                CopyableTextColumn::make('nama')
                    ->copyMessage('Nama AKun Tercopy')
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
            ->headerActions([
                CreateAction::make(),
                Action::make('cetak')
                    ->label('Cetak Struktur Akun 3')
                    ->icon('heroicon-o-printer')
                    ->url(route('level3.print'))
                    ->openUrlInNewTab(),
                // AssociateAction::make(),
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
