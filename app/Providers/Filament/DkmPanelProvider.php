<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Support\Facades\Auth;
use function Filament\Support\original_request;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\LaporanNeraca;
use App\Filament\Pages\LaporanBukuBesar;
use App\Filament\Pages\LaporanNeracaTransaksi;
use App\Filament\Resources\AKuns\AKunResource;
use App\Filament\Resources\Kelompoks\KelompokResource;
use App\Filament\Resources\Masjids\MasjidResource;
use App\Filament\Resources\Pagus\PaguResource;
use App\Filament\Resources\Rekenings\RekeningResource;
use App\Filament\Resources\Reks\RekResource;
use App\Filament\Resources\SubReks\SubRekResource;
use App\Filament\Resources\Tahuns\TahunResource;
use App\Filament\Resources\Transaksis\TransaksiResource;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\Users\UserResource;
use App\Http\Controllers\LaporanNeracaTransaksiPdfController;

use BezhanSalleh\FilamentShield\Resources\Roles\RoleResource;
use Filament\Enums\GlobalSearchPosition;
use Filament\Support\Enums\Width;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;

class DkmPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dkm')
            ->path('dkm')
            // ->spa()
            ->login()
            ->plugins([
                FilamentShieldPlugin::make(),
                AuthUIEnhancerPlugin::make()
                    ->formPanelPosition('left')
                    ->formPanelWidth('40%')
                    ->formPanelBackgroundColor(Color::Cyan, '700')
                    ->emptyPanelBackgroundImageOpacity('90%')
                    ->emptyPanelBackgroundImageUrl(asset('images/alkautsar3.png'))
            ])
            ->registration()

            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
                // \App\Filament\Widgets\AsnafChartWidget::class,
                // \App\Filament\Widgets\SystemInfoWidget::class,
                // \App\Filament\Widgets\AsnafSummaryWidget::class,

            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/dkm/theme.css')
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            // ->topbar(false)
            ->globalSearch(position: GlobalSearchPosition::Sidebar)
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder
                    ->items([
                        NavigationItem::make('Dashboard')
                            ->icon('heroicon-o-home')
                            ->isActiveWhen(fn(): bool => original_request()->routeIs('filament.admin.pages.dashboard'))
                            ->url(fn(): string => Dashboard::getUrl()),
                    ])
                    ->groups([
                        NavigationGroup::make('Modul Admin')
                            ->collapsed()
                            ->items([
                                // Urutan: Tahun dulu (setting dasar), lalu User
                                ...(TahunResource::canViewAny() ? TahunResource::getNavigationItems() : []),
                                ...(MasjidResource::canViewAny() ? MasjidResource::getNavigationItems() : []),

                            ]),
                        NavigationGroup::make('Modul Anggaran')
                            ->label('Kelola Anggaran')
                            ->items([
                                ...(PaguResource::canViewAny() ? PaguResource::getNavigationItems() : []),
                            ]),
                        NavigationGroup::make('Modul User')
                            ->label('Kelola User')
                            ->items([
                                ...(UserResource::canViewAny() ? UserResource::getNavigationItems() : []),
                                ...(RekResource::canViewAny() ? RekResource::getNavigationItems() : []),
                                ...(SubRekResource::canViewAny() ? SubRekResource::getNavigationItems() : []),
                                ...(RekeningResource::canViewAny() ? RekeningResource::getNavigationItems() : []),
                            ]),
                        NavigationGroup::make('Modul Bendahara')
                            ->label('Modul Bendahara')
                            ->items([
                                ...(TransaksiResource::canViewAny() ? TransaksiResource::getNavigationItems() : []),

                                // ...SaldoAwalResource::getNavigationItems(),
                                // ...BuktiResource::getNavigationItems(),
                                // ...MutasiResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Modul ZIS')
                            ->items([
                                // ...AsnafResource::getNavigationItems(),
                                // ...DetilAsnafResource::getNavigationItems(),
                                // ...SalurZakatResource::getNavigationItems(),
                            ]),
                        NavigationGroup::make('Laporan Keuangan')
                            ->items(array_filter([
                                NavigationItem::make('Laporan Neraca')
                                    ->icon('heroicon-o-document-chart-bar')
                                    ->url(fn(): string => LaporanNeracaTransaksi::getUrl()),
                                NavigationItem::make('Laporan Buku Besar')
                                    ->icon('heroicon-o-book-open')
                                    ->url(fn(): string => LaporanBukuBesar::getUrl()),
                                // ...(LaporanBukuBesar::canViewAny() ? [NavigationItem::make('Laporan Buku Besar')
                                //     ->icon('heroicon-o-book-open')
                                //     ->url(fn(): string => LaporanBukuBesar::getUrl())] : []),
                                // ...(LaporanNeracaTransaksi::canViewAny() ? [NavigationItem::make('Laporan Neraca Masjid')
                                //     ->icon('heroicon-o-document-chart-bar')
                                //     ->url(fn(): string => LaporanNeracaTransaksi::getUrl())] : []),
                            ])),
                        NavigationGroup::make('Role & Permission')
                            ->items([
                                ...(RoleResource::canViewAny() ? RoleResource::getNavigationItems() : []),
                                // ...PermissionResoure::getNavigationItems(),
                            ]),

                    ]);
            });
    }
}

        //    ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
        //         return $builder
        //             ->items([
        //                 NavigationItem::make('Dashboard')
        //                     ->icon('heroicon-o-home')
        //                     ->isActiveWhen(fn(): bool => original_request()->routeIs('filament.admin.pages.dashboard'))
        //                     ->url(fn(): string => Dashboard::getUrl()),
        //             ])
        //             ->groups([
        //                 NavigationGroup::make('Modul Admin')
        //                     ->collapsed()
        //                     ->items([
        //                         // Urutan: Tahun dulu (setting dasar), lalu User
        //                         ...TahunResource::getNavigationItems(),
        //                         ...StrukturResource::getNavigationItems(),
        //                         ...PengurusResource::getNavigationItems(),
        //                         ...TugasResource::getNavigationItems(),
        //                         ...Level1Resource::getNavigationItems(),
        //                         ...Level2Resource::getNavigationItems(),
        //                         ...SumberDanaResource::getNavigationItems(),
        //                         ...JamaahResource::getNavigationItems(),
        //                     ]),
        //                 NavigationGroup::make('Modul Anggaran')
        //                     ->label('Kelola Anggaran')
        //                     ->items([
        //                         ...AnggaranResource::getNavigationItems(),
        //                     ]),
        //                 NavigationGroup::make('Modul User')
        //                     ->label('Kelola User')
        //                     ->items([
        //                         ...UserResource::getNavigationItems(),
        //                     ]),
        //                 NavigationGroup::make('Modul Bendahara')
        //                     ->label('Modul Bendahara')
        //                     ->items([
        //                         ...SaldoAwalResource::getNavigationItems(),
        //                         ...BuktiResource::getNavigationItems(),
        //                         ...MutasiResource::getNavigationItems(),
        //                     ]),
        //                 NavigationGroup::make('Modul ZIS')
        //                     ->items([
        //                         ...AsnafResource::getNavigationItems(),
        //                         ...DetilAsnafResource::getNavigationItems(),
        //                         ...SalurZakatResource::getNavigationItems(),
        //                     ]),
        //                 NavigationGroup::make('Role & Permission')
        //                     ->items([
        //                         ...RoleResource::getNavigationItems(),
        //                         // ...PermissionResoure::getNavigationItems(),
        //                     ]),

        //             ]);
        //     });
