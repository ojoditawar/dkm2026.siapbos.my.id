<?php

namespace App\Filament\Resources\Mutasis\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Level2;

class DetailmutasiRelationManager extends RelationManager
{
    protected static string $relationship = 'detailMutasis';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('level2_id')
                    ->label('Tempat Penyimpanan Kas/Pembayaran Kas')
                    ->options(function ($get) {
                        return Level2::whereHas('level1', function ($query) {
                            $query->where('akun1', '1');
                        })->orderBy('nama', 'asc')->pluck('nama', 'id');
                    })->columnSpanFull(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->currencyMask(thousandSeparator: ',', decimalSeparator: '.', precision: 0)
                    ->required(),
                Select::make('kolom')
                    ->label('D/K')
                    ->options([
                        'D' => 'D',
                        'K' => 'K',
                    ])
                    ->required()
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('level2.nama'),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->formatStateUsing(function ($state, $record) {
                        $jumlah = (float) str_replace(',', '', $state);
                        if ($record->kolom === 'K') {
                            $jumlah = -$jumlah;
                        }
                        return number_format($jumlah, 0, ',', '.');
                    }),
                TextColumn::make('kolom')
                    ->label('D/K')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'D' => 'success',
                        'K' => 'danger',
                        default => 'gray',
                    }),
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
