<?php

namespace App\Filament\Admin\Resources\UserResource\Pages;

use App\Filament\Admin\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Models\User;
use App\Models\Facility;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Tabs;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Profile')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Group::make([
                                    TextEntry::make('name')
                                        ->label('Full Name')
                                        ->weight('bold')
                                        ->size(TextEntry\TextEntrySize::Large),
                                    TextEntry::make('email')
                                        ->icon('heroicon-o-envelope')
                                        ->copyable(),
                                ])
                                ->columnSpan(1),
                                
                                Group::make([
                                    TextEntry::make('role')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'admin' => 'gray',
                                            'provider' => 'warning',
                                            'biker' => 'success',
                                            'consumer' => 'info',
                                            default => 'gray',
                                        }),
                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn (?string $state): string => match ($state ?? '') {
                                            'pending' => 'warning',
                                            'approved' => 'success',
                                            'rejected' => 'danger',
                                            'suspended' => 'gray',
                                            default => 'gray',
                                        }),
                                ])
                                ->columnSpan(1),
                                
                                Group::make([
                                    TextEntry::make('created_at')
                                        ->label('Registered On')
                                        ->date('F j, Y')
                                        ->icon('heroicon-o-calendar'),
                                    TextEntry::make('phone')
                                        ->icon('heroicon-o-phone')
                                        ->url(fn ($state) => $state ? "tel:{$state}" : null),
                                ])
                                ->columnSpan(1),
                            ]),
                    ]),

                Tabs::make('User Details')
                    ->tabs([
                        Tabs\Tab::make('Contact & Location')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                TextEntry::make('address')
                                    ->label('Address')
                                    ->columnSpanFull(),
                                
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('latitude')
                                            ->label('Latitude')
                                            ->numeric(6),
                                        TextEntry::make('longitude')
                                            ->label('Longitude')
                                            ->numeric(6),
                                    ]),
                                
                                TextEntry::make('map')
                                    ->label('')
                                    ->columnSpanFull()
                                    ->html(function (User $record) {
                                        if (!$record->latitude || !$record->longitude) {
                                            return '<div class="text-gray-500 italic">Location coordinates not available</div>';
                                        }
                                        
                                        return '
                                            <div id="user-map" style="height: 400px; width: 100%; border-radius: 0.5rem; margin-top: 0.5rem;"></div>
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    if (typeof mapboxgl !== "undefined") {
                                                        mapboxgl.accessToken = "' . config('services.mapbox.token', env('MAPBOX_ACCESS_TOKEN', '')) . '";
                                                        const map = new mapboxgl.Map({
                                                            container: "user-map",
                                                            style: "mapbox://styles/mapbox/streets-v11",
                                                            center: [' . $record->longitude . ', ' . $record->latitude . '],
                                                            zoom: 14
                                                        });
                                                        
                                                        // Add marker
                                                        new mapboxgl.Marker({
                                                            color: "#10B981"
                                                        })
                                                        .setLngLat([' . $record->longitude . ', ' . $record->latitude . '])
                                                        .setPopup(
                                                            new mapboxgl.Popup({offset: 25})
                                                                .setHTML("<h3>' . e($record->name) . '</h3><p>' . e($record->address) . '</p>")
                                                        )
                                                        .addTo(map);
                                                        
                                                        // Add navigation controls
                                                        map.addControl(new mapboxgl.NavigationControl());
                                                    }
                                                });
                                            </script>
                                        ';
                                    }),
                            ]),

                        Tabs\Tab::make('Provider Details')
                            ->icon('heroicon-o-building-office')
                            ->visible(fn (User $record): bool => $record->role === 'provider')
                            ->schema([
                                TextEntry::make('government_id')
                                    ->label('Government ID')
                                    ->copyable(),
                                TextEntry::make('communication_preference')
                                    ->label('Preferred Contact Method')
                                    ->badge(),
                                IconEntry::make('is_facility_admin')
                                    ->label('Facility Administrator')
                                    ->boolean(),
                                TextEntry::make('facility.name')
                                    ->label('Associated Facility')
                                    ->url(fn (User $record): ?string => $record->facility ? 
                                        route('filament.admin.resources.facilities.view', ['record' => $record->facility_id]) 
                                        : null)
                                    ->color('primary')
                                    ->placeholder('No facility associated'),
                            ]),
                            
                        Tabs\Tab::make('Consumer Details')
                            ->icon('heroicon-o-user-circle')
                            ->visible(fn (User $record): bool => $record->role === 'consumer')
                            ->schema([
                                TextEntry::make('blood_group')
                                    ->label('Blood Group')
                                    ->badge()
                                    ->color('danger'),
                                TextEntry::make('communication_preference')
                                    ->label('Preferred Contact Method')
                                    ->badge(),
                                // We could add consumer-specific fields here in the future
                            ]),
                            
                        Tabs\Tab::make('Account & Security')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified')
                                    ->placeholder('Not verified')
                                    ->date('F j, Y g:i a'),
                                // More security information can be added here
                            ]),
                            
                        Tabs\Tab::make('Activity')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                TextEntry::make('orders_count')
                                    ->label('Total Orders')
                                    // ->state(function (User $record): int {
                                    //     return \App\Models\Order::where('user_id', $record->id)->count();
                                    // })
                                    ->badge()
                                    ->color('success'),
                                // More activity information can be added here
                            ]),
                    ]),
            ]);
    }
    
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit User'),
                
            Action::make('approve')
                ->label('Approve Provider')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (User $record) => $record->role === 'provider' && $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('Approve Provider')
                ->modalDescription('Are you sure you want to approve this provider? This will also approve their facility if they have one.')
                ->modalSubmitActionLabel('Yes, Approve Provider')
                ->action(function (User $record) {
                    try {
                        DB::transaction(function () use ($record) {
                            $record->status = 'approved';
                            $record->save();
                            
                            if ($record->facility_id) {
                                $facility = Facility::find($record->facility_id);
                                if ($facility && $facility->status === 'pending') {
                                    $facility->status = 'approved';
                                    $facility->save();
                                }
                            }
                        });
                        
                        Notification::make()
                            ->title('Provider Approved')
                            ->success()
                            ->send();
                            
                        $this->redirect(route('filament.admin.resources.users.view', ['record' => $record]));
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Approval Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
                
            Action::make('reject')
                ->label('Reject Provider')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (User $record) => $record->role === 'provider' && $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('Reject Provider')
                ->modalDescription('Are you sure you want to reject this provider? This will also reject their facility if they have one.')
                ->modalSubmitActionLabel('Yes, Reject Provider')
                ->action(function (User $record) {
                    try {
                        DB::transaction(function () use ($record) {
                            $record->status = 'rejected';
                            $record->save();
                            
                            if ($record->facility_id) {
                                $facility = Facility::find($record->facility_id);
                                if ($facility && $facility->status === 'pending') {
                                    $facility->status = 'rejected';
                                    $facility->save();
                                }
                            }
                        });
                        
                        Notification::make()
                            ->title('Provider Rejected')
                            ->success()
                            ->send();
                            
                        $this->redirect(route('filament.admin.resources.users.view', ['record' => $record]));
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Rejection Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}