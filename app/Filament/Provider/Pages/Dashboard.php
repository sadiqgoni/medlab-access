<?php

namespace App\Filament\Provider\Pages;

use App\Filament\Provider\Resources\ServiceResource;
use App\Models\Service;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Contracts\View\View;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.provider.pages.dashboard';

    public function getHeaderWidgetsColumns(): int 
    {
        return 3;
    }

    public function getHeader(): ?View
    {
        $user = Auth::user();
        $welcomeMessage = 'Welcome back, ' . $user->name . '!';
        
        return view('filament.provider.pages.dashboard-header', [
            'welcomeMessage' => $welcomeMessage
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('add_service')
                ->label('Add New Service')
                ->icon('heroicon-o-plus-circle')
                ->color('primary')
                ->url(ServiceResource::getUrl('create')),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Provider\Widgets\ServiceStatsWidget::class,
            \App\Filament\Provider\Widgets\PendingServicesWidget::class,
        ];
    }
}
