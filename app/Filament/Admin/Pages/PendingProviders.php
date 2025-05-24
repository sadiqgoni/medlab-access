<?php

namespace App\Filament\Admin\Pages;

use App\Models\User;
use App\Models\Facility;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class PendingProviders extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Pending Providers';
    protected static ?string $title = 'Pending Provider Approvals';
    protected static ?string $navigationGroup = 'Provider Management';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.admin.pages.pending-providers';

    public static function getNavigationBadge(): ?string
    {
        return User::where('role', 'provider')
            ->where('status', 'pending')
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->where('role', 'provider')
                    ->where('status', 'pending')
                    ->latest()
            )
            ->heading('Pending Provider Approvals')
            ->description('Review and approve new healthcare providers who have registered on the platform.')
            ->columns([
                TextColumn::make('name')
                    ->label('Provider Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('facility.name')
                    ->label('Facility')
                    ->description(fn (User $record): ?string => $record->facility?->type)
                    ->placeholder('No Facility')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('facility.address')
                    ->label('Location')
                    ->limit(40)
                    ->tooltip(fn (User $record): ?string => $record->facility?->address)
                    ->placeholder('-')
                    ->toggleable(),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                    ])
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                // No filters needed as we're already filtering for pending providers
            ])
            ->actions([
                Action::make('view_details')
                    ->label('View Details')
                    ->icon('heroicon-o-eye')
                    ->color('secondary')
                    ->url(fn (User $record): string => route('filament.admin.resources.users.edit', $record)),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
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
                                ->body('The provider and their facility have been approved successfully.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Approval Failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
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
                                ->body('The provider and their facility have been rejected.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Rejection Failed')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                // Bulk approval action
                \Filament\Tables\Actions\BulkAction::make('bulk_approve')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                        $processed = 0;
                        
                        DB::transaction(function () use ($records, &$processed) {
                            foreach ($records as $provider) {
                                $provider->status = 'approved';
                                $provider->save();
                                
                                if ($provider->facility_id) {
                                    $facility = Facility::find($provider->facility_id);
                                    if ($facility && $facility->status === 'pending') {
                                        $facility->status = 'approved';
                                        $facility->save();
                                    }
                                }
                                
                                $processed++;
                            }
                        });
                        
                        Notification::make()
                            ->title("{$processed} Providers Approved")
                            ->success()
                            ->send();
                    }),
                
                // Bulk reject action
                \Filament\Tables\Actions\BulkAction::make('bulk_reject')
                    ->label('Reject Selected')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (\Illuminate\Database\Eloquent\Collection $records) {
                        $processed = 0;
                        
                        DB::transaction(function () use ($records, &$processed) {
                            foreach ($records as $provider) {
                                $provider->status = 'rejected';
                                $provider->save();
                                
                                if ($provider->facility_id) {
                                    $facility = Facility::find($provider->facility_id);
                                    if ($facility && $facility->status === 'pending') {
                                        $facility->status = 'rejected';
                                        $facility->save();
                                    }
                                }
                                
                                $processed++;
                            }
                        });
                        
                        Notification::make()
                            ->title("{$processed} Providers Rejected")
                            ->success()
                            ->send();
                    }),
            ]);
    }
}