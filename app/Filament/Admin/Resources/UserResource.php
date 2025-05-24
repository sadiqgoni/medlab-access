<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Facility;
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
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        // Show count of pending providers in the navigation
        return static::getModel()::where('role', 'provider')
            ->where('status', 'pending')
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
                Tabs::make('User Details')
                    ->tabs([
                        Tab::make('Basic Information')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\Select::make('role')
                                    ->options([
                                        'admin' => 'Admin',
                                        'provider' => 'Provider',
                                        'biker' => 'Biker',
                                        'consumer' => 'Consumer',
                                    ])
                                    ->required()
                                    ->reactive(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'pending' => 'Pending Approval',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                        'suspended' => 'Suspended',
                                    ])
                                    ->default('pending')
                                    ->required()
                                    ->visible(fn ($get) => $get('role') === 'provider'),
                            ]),
                        
                        Tab::make('Address & Location')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Forms\Components\Textarea::make('address')
                                    ->columnSpanFull(),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->numeric()
                                            ->default(null),
                                        Forms\Components\TextInput::make('longitude')
                                            ->numeric()
                                            ->default(null),
                                    ]),
                            ]),
                            
                        Tab::make('Provider Details')
                            ->icon('heroicon-o-building-office')
                            ->visible(fn ($get) => $get('role') === 'provider')
                            ->schema([
                                Forms\Components\TextInput::make('government_id')
                                    ->label('Government ID Number')
                                    ->maxLength(255),
                                Forms\Components\Toggle::make('is_facility_admin')
                                    ->label('Is Facility Administrator')
                                    ->helperText('Designates this user as a facility administrator'),
                                Forms\Components\Select::make('communication_preference')
                                    ->options([
                                        'email' => 'Email',
                                        'sms' => 'SMS',
                                        'app' => 'App Notifications',
                                    ]),
                                Forms\Components\Select::make('facility_id')
                                    ->relationship('facility', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\Textarea::make('address')
                                            ->required(),
                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'Lab' => 'Laboratory',
                                                'Hospital' => 'Hospital',
                                                'Clinic' => 'Clinic',
                                                'Blood Bank' => 'Blood Bank',
                                                'Other' => 'Other',
                                            ])
                                            ->required(),
                                    ]),
                            ]),
                            
                        Tab::make('Consumer Details')
                            ->icon('heroicon-o-user-circle')
                            ->visible(fn ($get) => $get('role') === 'consumer')
                            ->schema([
                                Forms\Components\TextInput::make('blood_group')
                                    ->maxLength(255),
                                Forms\Components\Select::make('communication_preference')
                                    ->options([
                                        'email' => 'Email',
                                        'sms' => 'SMS',
                                        'app' => 'App Notifications',
                                    ]),
                            ]),
                            
                        Tab::make('Security')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->maxLength(255),
                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->label('Email Verified At'),
                            ]),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'gray',
                        'provider' => 'warning',
                        'biker' => 'success',
                        'consumer' => 'info',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
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
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'provider' => 'Provider',
                        'biker' => 'Biker',
                        'consumer' => 'Consumer',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Approval',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'suspended' => 'Suspended',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (User $record): bool => $record->role === 'provider' && $record->status === 'pending')
                    ->action(function (User $record) {
                        try {
                            DB::transaction(function () use ($record) {
                                $record->status = 'approved';
                                $record->save();
                                
                                if ($record->facility_id) {
                                    $facility = Facility::find($record->facility_id);
                                    if ($facility) {
                                        $facility->status = 'approved';
                                        $facility->save();
                                    }
                                }
                                
                                // Additional logic for approving provider
                                // You could send email notifications here
                            });
                            
                            Notification::make()
                                ->title('Provider Approved')
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
                    ->visible(fn (User $record): bool => $record->role === 'provider' && $record->status === 'pending')
                    ->action(function (User $record) {
                         try {
                            DB::transaction(function () use ($record) {
                                $record->status = 'rejected';
                                $record->save();

                                if ($record->facility_id) {
                                    $facility = Facility::find($record->facility_id);
                                    if ($facility) {
                                        $facility->status = 'rejected';
                                        $facility->save();
                                    }
                                }
                                // Optionally: Send notification to user
                            });
                            Notification::make()
                                ->title('Provider Rejected')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
