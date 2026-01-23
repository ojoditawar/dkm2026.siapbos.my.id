<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class SystemInfoWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            // Stat::make('PHP Version', PHP_VERSION)
            //     ->description('Current PHP version')
            //     ->descriptionIcon('heroicon-m-code-bracket')
            //     ->color('success'),

            // Stat::make('Laravel Version', app()->version())
            //     ->description('Framework version')
            //     ->descriptionIcon('heroicon-m-rocket-launch')
            //     ->color('primary'),

            // Stat::make('Cache Driver', ucfirst(config('cache.default')))
            //     ->description('Current cache driver')
            //     ->descriptionIcon('heroicon-m-server')
            //     ->color('warning'),

            // Stat::make('Memory Usage', round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB')
            //     ->description('Current memory usage')
            //     ->descriptionIcon('heroicon-m-cpu-chip')
            //     ->color('info'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('clearCache')
                ->label('🗑️ Clear Cache')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Clear Application Cache')
                ->modalDescription('Apakah Anda yakin ingin menghapus semua cache aplikasi?')
                ->action(function () {
                    try {
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
                }),

            Action::make('optimizeApp')
                ->label('⚡ Optimize')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Optimize Application')
                ->modalDescription('Ini akan mengoptimalkan aplikasi untuk performa yang lebih baik.')
                ->action(function () {
                    try {
                        Artisan::call('config:cache');
                        Artisan::call('route:cache');
                        Artisan::call('view:cache');
                        Artisan::call('optimize');

                        Notification::make()
                            ->title('Aplikasi Berhasil Dioptimalkan!')
                            ->body('Cache telah dibuat untuk performa optimal.')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Gagal Mengoptimalkan Aplikasi')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
