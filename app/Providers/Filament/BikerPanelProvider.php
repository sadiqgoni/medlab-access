<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\VerifyIsBiker;

class BikerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('biker')
            ->path('biker')
            ->brandName('DHR SPACE Delivery')
            ->brandLogo(asset('images/dhrlogo.jpg'))
            ->favicon(asset('images/favicon.ico'))
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->font('Inter')
            ->darkMode(false)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Dashboard',
                'Delivery Management',
                'Route Planning',
                'Performance',
                'Account'
            ])
            ->discoverResources(in: app_path('Filament/Biker/Resources'), for: 'App\\Filament\\Biker\\Resources')
            ->discoverPages(in: app_path('Filament/Biker/Pages'), for: 'App\\Filament\\Biker\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Biker/Widgets'), for: 'App\\Filament\\Biker\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Biker-specific widgets will be discovered
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
                \App\Http\Middleware\RedirectUser::class,
            ])
            ->spa();
    }
}
