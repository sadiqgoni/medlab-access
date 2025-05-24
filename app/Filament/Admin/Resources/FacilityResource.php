<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FacilityResource\Pages;
use App\Filament\Admin\Resources\FacilityResource\RelationManagers;
use App\Models\Facility;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'Healthcare Facilities';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Facility Management';

    public static function getNavigationBadge(): ?string
    {
        // Show count of pending facilities in navigation
        return static::getModel()::where('status', 'pending')
            ->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Facility Information')
                    ->description('Basic facility details and status')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending Approval',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->required()
                                    ->default('pending')
                                    ->columnSpan(1),
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'Lab' => 'Laboratory',
                                        'Hospital' => 'Hospital',
                                        'Clinic' => 'Clinic', 
                                        'Blood Bank' => 'Blood Bank',
                                        'Other' => 'Other',
                                    ])
                                    ->required()
                                    ->columnSpan(1),
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name', function ($query) {
                                        return $query->where('role', 'provider');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->label('Facility Administrator')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Section::make('Contact Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contact_person')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('license_number')
                                    ->label('License/Registration Number')
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make('Location')
                    ->schema([
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->default(null),
                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->default(null),
                            ]),
                        Forms\Components\Placeholder::make('map')
                            ->label('Location Map')
                            ->content(fn (Facility $record): string => 
                                $record->latitude && $record->longitude
                                    ? '<div id="map" style="height: 300px; border-radius: 0.5rem; margin-top: 0.5rem;"></div>
                                      <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            if (typeof mapboxgl !== "undefined") {
                                                mapboxgl.accessToken = "' . config('services.mapbox.token') . '";
                                                const map = new mapboxgl.Map({
                                                    container: "map",
                                                    style: "mapbox://styles/mapbox/streets-v11",
                                                    center: [' . $record->longitude . ', ' . $record->latitude . '],
                                                    zoom: 14
                                                });
                                                
                                                // Add marker
                                                new mapboxgl.Marker()
                                                    .setLngLat([' . $record->longitude . ', ' . $record->latitude . '])
                                                    .addTo(map);
                                            }
                                        });
                                      </script>'
                                    : 'Location coordinates not available'
                            )
                            ->columnSpanFull()
                            ->hidden(fn ($record) => !$record || !$record->latitude || !$record->longitude),
                    ]),
                
                Section::make('Services')
                    ->schema([
                        Forms\Components\Textarea::make('services_description')
                            ->label('Services Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('services_offered')
                            ->label('Services Offered (detailed)')
                            ->helperText('Detailed list of services offered by this facility')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Facility $record): string => $record->type),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Administrator')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'suspended' => 'gray',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(true)
                    ->icon('heroicon-o-phone'),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->toggleable(true)
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Approval',
                        'approved' => 'Approved', 
                        'rejected' => 'Rejected',
                        'suspended' => 'Suspended',
                    ]),
                SelectFilter::make('type')
                    ->options([
                        'Lab' => 'Laboratory',
                        'Hospital' => 'Hospital',
                        'Clinic' => 'Clinic',
                        'Blood Bank' => 'Blood Bank',
                        'Other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                    Tables\Actions\ViewAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Facility $record): bool => $record->status === 'pending')
                    ->action(function (Facility $record) {
                        try {
                            DB::transaction(function () use ($record) {
                                // Update facility status
                                $record->status = 'approved';
                                $record->save();
                                
                                // Also update the facility owner's status
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
                    ->visible(fn (Facility $record): bool => $record->status === 'pending')
                    ->action(function (Facility $record) {
                        try {
                            DB::transaction(function () use ($record) {
                                // Update facility status
                                $record->status = 'rejected';
                                $record->save();
                                
                                // Optionally update the provider status as well
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approveBulk')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $updated = 0;
                            
                            DB::transaction(function () use ($records, &$updated) {
                                foreach ($records as $record) {
                                    if ($record->status === 'pending') {
                                        $record->status = 'approved';
                                        $record->save();
                                        
                                        // Update associated provider as well
                                        if ($record->user_id) {
                                            $user = User::find($record->user_id);
                                            if ($user && $user->status === 'pending') {
                                                $user->status = 'approved';
                                                $user->save();
                                            }
                                        }
                                        
                                        $updated++;
                                    }
                                }
                            });
                            
                            Notification::make()
                                ->title("{$updated} facilities approved")
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'view' => Pages\ViewFacility::route('/{record}'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }
}
