<?php

namespace App\Filament\Admin\Resources\FacilityResource\Pages;

use App\Filament\Admin\Resources\FacilityResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Tabs;

class ViewFacility extends ViewRecord
{
    protected static string $resource = FacilityResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Facility Overview')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Group::make([
                                    TextEntry::make('name')
                                        ->label('Facility Name')
                                        ->weight('bold')
                                        ->size(TextEntry\TextEntrySize::Large),
                                    TextEntry::make('type')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'Lab' => 'info',
                                            'Hospital' => 'warning',
                                            'Clinic' => 'success',
                                            'Blood Bank' => 'danger',
                                            default => 'gray',
                                        }),
                                ])
                                ->columnSpan(1),
                                
                                Group::make([
                                    TextEntry::make('license_number')
                                        ->label('License Number')
                                        ->icon('heroicon-o-identification'),
                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
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
                                    TextEntry::make('user.name')
                                        ->label('Administrator')
                                        ->url(fn ($record) => $record->user ? 
                                            route('filament.admin.resources.users.view', ['record' => $record->user_id]) 
                                            : null)
                                        ->openUrlInNewTab()
                                        ->icon('heroicon-o-user')
                                        ->placeholder('No administrator assigned'),
                                ])
                                ->columnSpan(1),
                            ]),
                    ]),

                Tabs::make('Facility Details')
                    ->tabs([
                        Tabs\Tab::make('Contact Information')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('contact_person')
                                            ->label('Contact Person')
                                            ->icon('heroicon-o-user'),
                                        TextEntry::make('phone')
                                            ->label('Phone Number')
                                            ->icon('heroicon-o-phone')
                                            ->url(fn ($state) => $state ? "tel:{$state}" : null),
                                        TextEntry::make('email')
                                            ->label('Email Address')
                                            ->icon('heroicon-o-envelope')
                                            ->url(fn ($state) => $state ? "mailto:{$state}" : null),
                                        TextEntry::make('user.phone')
                                            ->label('Administrator Phone')
                                            ->icon('heroicon-o-device-phone-mobile')
                                            ->placeholder('Not provided')
                                            ->url(fn ($state) => $state ? "tel:{$state}" : null),
                                    ]),
                            ]),

                        Tabs\Tab::make('Location & Address')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                TextEntry::make('address')
                                    ->label('Full Address')
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
                                    ->html(function (Facility $record) {
                                        if (!$record->latitude || !$record->longitude) {
                                            return '<div class="text-gray-500 italic">Location coordinates not available</div>';
                                        }
                                        
                                        return '
                                            <div id="facility-map" style="height: 400px; width: 100%; border-radius: 0.5rem; margin-top: 0.5rem;"></div>
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    if (typeof mapboxgl !== "undefined") {
                                                        mapboxgl.accessToken = "' . config('services.mapbox.token', env('MAPBOX_ACCESS_TOKEN', '')) . '";
                                                        const map = new mapboxgl.Map({
                                                            container: "facility-map",
                                                            style: "mapbox://styles/mapbox/streets-v11",
                                                            center: [' . $record->longitude . ', ' . $record->latitude . '],
                                                            zoom: 14
                                                        });
                                                        
                                                        // Add marker
                                                        new mapboxgl.Marker({
                                                            color: "#FF5733"
                                                        })
                                                        .setLngLat([' . $record->longitude . ', ' . $record->latitude . '])
                                                        .setPopup(
                                                            new mapboxgl.Popup({offset: 25})
                                                                .setHTML("<h3>' . e($record->name) . '</h3><p>' . e($record->type) . '</p><p>' . e($record->address) . '</p>")
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

                        Tabs\Tab::make('Services')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                TextEntry::make('services_description')
                                    ->label('Services Overview')
                                    ->columnSpanFull(),
                                TextEntry::make('services_offered')
                                    ->label('Detailed Services')
                                    ->columnSpanFull()
                                    ->markdown(),
                                TextEntry::make('services_count')
                                    ->label('Available Services')
                                    // ->state(function (Facility $record): int {
                                    //     return $record->services()->count();
                                    // })
                                    ->placeholder('No services defined')
                                    ->badge(),
                            ]),
                            
                        Tabs\Tab::make('Orders & Analytics')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('orders_count')
                                            ->label('Total Orders')
                                            ->state(function (Facility $record): int {
                                                return \App\Models\Order::where('facility_id', $record->id)->count();
                                            })
                                            ->color('success'),
                                        TextEntry::make('pending_orders')
                                            ->label('Pending Orders')
                                            ->state(function (Facility $record): int {
                                                return \App\Models\Order::where('facility_id', $record->id)
                                                    ->whereIn('status', ['pending', 'processing'])
                                                    ->count();
                                            })
                                            ->color('warning'),
                                        TextEntry::make('completed_orders')
                                            ->label('Completed Orders')
                                            ->state(function (Facility $record): int {
                                                return \App\Models\Order::where('facility_id', $record->id)
                                                    ->where('status', 'completed')
                                                    ->count();
                                            })
                                            ->color('success'),
                                    ]),
                                // Here we could add charts/graphs in the future
                            ]),
                    ]),
            ]);
    }
    
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Edit Facility'),
                
            Action::make('approve')
                ->label('Approve Facility')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn (Facility $record) => $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('Approve Facility')
                ->modalDescription('Are you sure you want to approve this facility? This will also approve the facility administrator if they are pending.')
                ->modalSubmitActionLabel('Yes, Approve Facility')
                ->action(function (Facility $record) {
                    try {
                        DB::transaction(function () use ($record) {
                            $record->status = 'approved';
                            $record->save();
                            
                            if ($record->user_id) {
                                $user = User::find($record->user_id);
                                if ($user && $user->status === 'pending') {
                                    $user->status = 'approved';
                                    $user->save();
                                }
                            }
                        });
                        
                        Notification::make()
                            ->title('Facility Approved')
                            ->success()
                            ->send();
                            
                        $this->redirect(route('filament.admin.resources.facilities.view', ['record' => $record]));
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Approval Failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
                
            Action::make('reject')
                ->label('Reject Facility')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn (Facility $record) => $record->status === 'pending')
                ->requiresConfirmation()
                ->modalHeading('Reject Facility')
                ->modalDescription('Are you sure you want to reject this facility?')
                ->modalSubmitActionLabel('Yes, Reject Facility')
                ->action(function (Facility $record) {
                    try {
                        DB::transaction(function () use ($record) {
                            $record->status = 'rejected';
                            $record->save();
                            
                            if ($record->user_id) {
                                $user = User::find($record->user_id);
                                if ($user && $user->status === 'pending') {
                                    $user->status = 'rejected';
                                    $user->save();
                                }
                            }
                        });
                        
                        Notification::make()
                            ->title('Facility Rejected')
                            ->success()
                            ->send();
                            
                        $this->redirect(route('filament.admin.resources.facilities.view', ['record' => $record]));
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