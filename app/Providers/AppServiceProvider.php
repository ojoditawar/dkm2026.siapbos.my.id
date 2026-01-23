<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Filament\Actions\Action;
use Filament\Support\View\Components\ModalComponent;
use Filament\Tables\Table;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa locale Indonesia
        App::setLocale('id_ID');

        // Set locale untuk number formatting
        setlocale(LC_ALL, 'id_ID', 'id_ID.UTF-8', 'id');
        setlocale(LC_NUMERIC, 'id_ID'); // Khusus angka
        setlocale(LC_MONETARY, 'id_ID'); // Khusus uang

        // Konfigurasi hanya untuk table actions
        Table::configureUsing(function (Table $table): void {
            $table->modifyUngroupedRecordActionsUsing(
                fn(Action $action): Action =>
                $action->iconButton()  // Buat semua record actions jadi icon button
            );
        });

        Table::configureUsing(
            fn(Table $table) => $table
                ->striped()
                ->extremePaginationLinks()
            // ->defaultSort('nama', 'asc')
            // ->paginationPageOptions([11, 21, 31, 41, 51])
        );

        // Table::configureUsing(function (Table $table) {
        //     $table
        //         ->striped()
        //         ->extremePaginationLinks()
        //         ->paginationPageOptions([11, 21, 31, 41, 51]);
        // });

        ModalComponent::closedByClickingAway(false);
    }
}
