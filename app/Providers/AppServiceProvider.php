<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        // // Enhance Filament with custom styles and scripts
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::HEAD_END,
        //     fn (): string => Blade::render('
        //         <style>
        //             :root {
        //                 --primary-50: #eef7ff;
        //                 --primary-500: #1E88E5;
        //                 --primary-600: #0068d6;
        //             }
                    
        //             .fi-sidebar-nav-item-label {
        //                 font-weight: 500;
        //             }
                    
        //             .fi-sidebar-header {
        //                 background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
        //             }
                    
        //             .fi-brand {
        //                 color: white !important;
        //             }
                    
        //             .fi-logo {
        //                 max-height: 40px;
        //                 width: auto;
        //             }
                    
        //             .fi-topbar {
        //                 background: rgba(255, 255, 255, 0.95);
        //                 backdrop-filter: blur(10px);
        //                 border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        //             }
                    
        //             .fi-main {
        //                 background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        //                 min-height: 100vh;
        //             }
                    
        //             .fi-page {
        //                 background: transparent;
        //             }
                    
        //             .fi-section-content-ctn {
        //                 background: rgba(255, 255, 255, 0.9);
        //                 backdrop-filter: blur(10px);
        //                 border: 1px solid rgba(0, 0, 0, 0.05);
        //             }
        //         </style>
                
        //         <link rel="preconnect" href="https://fonts.googleapis.com">
        //         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        //         <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        //     ')
        // );
    }
}
