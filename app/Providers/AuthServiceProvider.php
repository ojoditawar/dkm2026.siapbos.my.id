<?php

namespace App\Providers;

use App\Filament\Pages\LaporanNeracaTransaksi;
use App\Policies\LaporanNeracaTransaksiPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        LaporanNeracaTransaksi::class => LaporanNeracaTransaksiPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
