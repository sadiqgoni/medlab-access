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
use App\Http\Middleware\VerifyIsProvider;

class ProviderPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('provider')
            ->path('provider')
            ->brandName('DHR Health Provider')
            ->brandLogo(asset('images/dhrlogo.jpg'))
            ->favicon(asset('images/favicon.ico'))
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->font('Inter')
            // ->darkMode(false)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Dashboard',
                'Service Management',
                'Order Management',
                'Facility Management',
                'Reports',
                'Account'
            ])
            ->discoverResources(in: app_path('Filament/Provider/Resources'), for: 'App\\Filament\\Provider\\Resources')
            ->discoverPages(in: app_path('Filament/Provider/Pages'), for: 'App\\Filament\\Provider\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Provider/Widgets'), for: 'App\\Filament\\Provider\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Provider-specific widgets will be discovered
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
