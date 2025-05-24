<?php

namespace App\Filament\Provider\Widgets;

use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ServiceStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $facilityId = Auth::user()->facility_id;
        
        // Count services by category and status
        $totalServices = Service::where('facility_id', $facilityId)->count();
        $approvedServices = Service::where('facility_id', $facilityId)
            ->where('status', 'approved')
            ->count();
        $pendingServices = Service::where('facility_id', $facilityId)
            ->where('status', 'pending')
            ->count();
            
        $eMedSampleCount = Service::where('facility_id', $facilityId)
            ->where('category', 'eMedSample')
            ->count();
        $sharedBloodCount = Service::where('facility_id', $facilityId)
            ->where('category', 'SharedBlood')
            ->count();

        return [
            Stat::make('Total Services', $totalServices)
                ->description('All defined services')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('gray'),
                
            Stat::make('Approved Services', $approvedServices)
                ->description('Available to customers')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->chart([
                    $approvedServices > 0 ? $approvedServices : 0, 
                    $pendingServices > 0 ? $pendingServices : 0
                ]),
                
            Stat::make('Pending Approval', $pendingServices)
                ->description('Awaiting admin review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingServices > 0 ? 'warning' : 'gray'),
                
            Stat::make('eMedSample Tests', $eMedSampleCount)
                ->description('Laboratory test services')
                ->descriptionIcon('heroicon-m-beaker')
                ->color('primary'),
                
            Stat::make('SharedBlood Services', $sharedBloodCount)
                ->description('Blood donation services')
                ->descriptionIcon('heroicon-m-heart')
                ->color('danger'),
        ];
    }
}
