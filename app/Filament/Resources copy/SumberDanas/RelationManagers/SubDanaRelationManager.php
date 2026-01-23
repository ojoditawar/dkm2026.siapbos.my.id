<?php

namespace App\Filament\Resources\SumberDanas\RelationManagers;

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

class SubDanaRelationManager extends RelationManager
{
    protected static string $relationship = 'SubDanas';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sub')
                    ->maxLength(2)
                    ->required()
                    ->columnSpanFull()
                    ->rules([
                        'required',
                        'max:2',
                    ])
                    ->validationMessages([
                        'required' => 'Sub Dana wajib diisi',
                        'max' => 'Sub Dana maksimal 2 karakter'
                    ])
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, $component) {
                        if (!$state) return;

                        $sumber = $this->getOwnerRecord()->kode;
                        if ($sumber && $state) {
                            $query = \App\Models\SubDana::where('sumber', $sumber)
                                ->where('sub', $state);

                            // Jika sedang edit, exclude record yang sedang diedit
                            if (isset($this->record) && $this->record) {
                                $query->where('id', '!=', $this->record->id);
                            }

                            if ($query->exists()) {
                                $sumberDana = $this->getOwnerRecord();
                                $namaSumber = $sumberDana ? $sumberDana->nama : $sumber;
                                $component->state(null);

                                \Filament\Notifications\Notification::make()
                                    ->title('Data Duplikat!')
                                    ->body("Data Sumber Dana '{$namaSumber}' dengan Sub Dana '{$state}' sudah ada.")
                                    ->danger()
                                    ->duration(4000)
                                    ->send();
                            }
                        }
                    }),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama')
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
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

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Validasi duplikasi sebelum create
        $sumber = $this->getOwnerRecord()->kode;
        $exists = \App\Models\SubDana::where('sumber', $sumber)
            ->where('sub', $data['sub'])
            ->exists();

        if ($exists) {
            $sumberDana = $this->getOwnerRecord();
            $namaSumber = $sumberDana ? $sumberDana->nama : $sumber;

            \Filament\Notifications\Notification::make()
                ->title('Data Duplikat Ditemukan!')
                ->body("Kombinasi Sumber Dana '{$namaSumber}' dengan Sub Dana '{$data['sub']}' sudah ada. Silakan gunakan kode sub yang berbeda.")
                ->danger()
                ->duration(5000)
                ->icon('heroicon-o-exclamation-triangle')
                ->send();

            $this->halt();
        }

        // Set sumber dari owner record
        $data['sumber'] = $sumber;

        return \App\Models\SubDana::create($data);
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Validasi duplikasi sebelum update (exclude current record)
        $sumber = $this->getOwnerRecord()->kode;
        $exists = \App\Models\SubDana::where('sumber', $sumber)
            ->where('sub', $data['sub'])
            ->where('id', '!=', $record->id)
            ->exists();

        if ($exists) {
            $sumberDana = $this->getOwnerRecord();
            $namaSumber = $sumberDana ? $sumberDana->nama : $sumber;

            \Filament\Notifications\Notification::make()
                ->title('Data Duplikat Ditemukan!')
                ->body("Kombinasi Sumber Dana '{$namaSumber}' dengan Sub Dana '{$data['sub']}' sudah ada. Silakan gunakan kode sub yang berbeda.")
                ->danger()
                ->duration(5000)
                ->icon('heroicon-o-exclamation-triangle')
                ->send();

            $this->halt();
        }

        // Set sumber dari owner record
        $data['sumber'] = $sumber;

        $record->update($data);
        return $record;
    }
}
