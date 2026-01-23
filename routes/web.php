<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Laravel\Fortify\Features;
use App\Http\Controllers\Level1PrintController;
use App\Http\Controllers\Level2PrintController;
use App\Http\Controllers\Level3PrintController;
use App\Http\Controllers\BuktiPrintController;
use App\Http\Controllers\SaldoAwalPrintController;
use App\Http\Controllers\SalurZakatPrintController;
use App\Http\Controllers\AnggaranPrintController;
use App\Http\Controllers\PaguPrintController;
use App\Http\Controllers\LaporanNeracaPdfController;
use App\Http\Controllers\LaporanBukuBesarPdfController;
use App\Http\Controllers\LaporanNeracaTransaksiPdfController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/level1/print', [Level1PrintController::class, 'show'])
//     ->name('level1.print');

// Route::get('/level2/print', [Level2PrintController::class, 'show'])
//     ->name('level2.print');

// Route::get('/level3/print', [Level3PrintController::class, 'show'])
//     ->name('level3.print');

Route::get('/bukti/{bukti}/print', [BuktiPrintController::class, 'show'])
    ->name('buktis.print');

Route::get('/saldoawal/print', [SaldoAwalPrintController::class, 'print'])
    ->name('saldoawal.print');

Route::get('/salur-zakat/print/{id}', [SalurZakatPrintController::class, 'print'])
    ->name('salur-zakat.print');

Route::get('/anggaran/print', [AnggaranPrintController::class, 'print'])
    ->name('anggaran.print');

Route::get('/pagu/print', [PaguPrintController::class, 'print'])
    ->name('pagu.print');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Cache Management Routes for Filament Dashboard
Route::middleware(['auth'])->group(function () {
    Route::post('filament/dkm/clear-cache', function () {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    })->name('filament.dkm.clear-cache');

    Route::post('filament/dkm/optimize-app', function () {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            Artisan::call('optimize');

            return response()->json([
                'success' => true,
                'message' => 'Aplikasi berhasil dioptimalkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    })->name('filament.dkm.optimize-app');
});

// Laporan PDF Routes
Route::get('/laporan-neraca-pdf', [LaporanNeracaPdfController::class, 'export'])
    ->middleware('auth')
    ->name('laporan.neraca.pdf');

Route::get('/laporan-buku-besar-pdf', [LaporanBukuBesarPdfController::class, 'generate'])
    ->middleware('auth')
    ->name('laporan.buku-besar.pdf');

Route::get('/laporan-neraca-transaksi-pdf', [LaporanNeracaTransaksiPdfController::class, 'export'])
    ->middleware('auth')
    ->name('laporan.neraca-transaksi.pdf');
