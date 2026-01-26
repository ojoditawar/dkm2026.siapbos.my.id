<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class Dashboard extends BaseDashboard
{

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clearCache')
                ->label('🗑️ Clear Cache XXX')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Clear Application Cache')
                ->modalDescription('Apakah Anda yakin ingin menghapus semua cache aplikasi? Ini akan membersihkan cache konfigurasi, route, view, dan aplikasi.')
                ->modalSubmitActionLabel('Ya, Hapus Cache')
                ->action(function () {
                    try {
                        // Clear various caches
                        Artisan::call('cache:clear');
                        Artisan::call('config:clear');
                        Artisan::call('route:clear');
                        Artisan::call('view:clear');
                        Artisan::call('optimize:clear');

                        Notification::make()
                            ->title('Cache Berhasil Dihapus!')
                            ->body('Semua cache aplikasi telah berhasil dibersihkan.')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal Menghapus Cache')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-trash'),

            Action::make('optimizeApp')
                ->label('⚡ Optimize App')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Optimize Application')
                ->modalDescription('Ini akan mengoptimalkan aplikasi dengan cache konfigurasi, route, dan view untuk performa yang lebih baik.')
                ->modalSubmitActionLabel('Ya, Optimize')
                ->action(function () {
                    try {
                        // Optimize application
                        Artisan::call('config:cache');
                        Artisan::call('route:cache');
                        Artisan::call('view:cache');
                        Artisan::call('optimize');

                        Notification::make()
                            ->title('Aplikasi Berhasil Dioptimalkan!')
                            ->body('Cache konfigurasi, route, dan view telah dibuat untuk performa optimal.')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal Mengoptimalkan Aplikasi')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->icon('heroicon-o-bolt'),
        ];
    }
}
