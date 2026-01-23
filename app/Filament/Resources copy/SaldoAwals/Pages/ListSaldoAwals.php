<?php

namespace App\Filament\Resources\SaldoAwals\Pages;

use App\Filament\Resources\SaldoAwals\SaldoAwalResource;
use Coolsam\Flatpickr\Forms\Components\Flatpickr;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;
use Jacobtims\InlineDateTimePicker\Forms\Components\InlineDateTimePicker;

class ListSaldoAwals extends ListRecords
{
    protected static string $resource = SaldoAwalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('cetak')
                ->label('Cetak Posisi Saldo Kas')
                ->icon('heroicon-o-printer')
                ->form([
                    \Filament\Forms\Components\Select::make('tahun_id')
                        ->label('Pilih Tahun')
                        ->options(\App\Models\Tahun::orderBy('tahun', 'desc')->pluck('tahun', 'id'))
                        ->default(function () {
                            $currentYear = date('Y');
                            $tahun = \App\Models\Tahun::where('tahun', $currentYear)->first();
                            return $tahun ? $tahun->id : null;
                        })
                        ->required(),
                    // \Filament\Forms\Components\DatePicker::make('tanggal_mulai')
                    DatePicker::make('tanggal_mulai')
                        ->columns(2)
                        ->label('Tanggal Mulai (Opsional)')
                        ->helperText('Kosongkan untuk filter berdasarkan tahun'),
                    DatePicker::make('tanggal_sampai')
                        ->columns(2)
                        ->label('Tanggal Sampai (Opsional)')
                        ->helperText('Kosongkan untuk filter berdasarkan tahun')
                ])
                ->action(function (array $data) {
                    $params = ['tahun_id' => $data['tahun_id']];

                    // Debug: lihat semua data yang diterima
                    // $params['tanggal_mulai'] = $data['tanggal_mulai'];
                    // dd($params);

                    if (!empty($data['tanggal_mulai'])) {
                        $params['tanggal_mulai'] = $data['tanggal_mulai'];
                    }
                    if (!empty($data['tanggal_sampai'])) {
                        $params['tanggal_sampai'] = $data['tanggal_sampai'];
                    }

                    // Debug: lihat params final
                    // dd($params);

                    $url = route('saldoawal.print', $params);

                    // Menggunakan JavaScript untuk membuka di tab baru
                    $this->js("window.open('$url', '_blank')");
                })
        ];
    }
}
