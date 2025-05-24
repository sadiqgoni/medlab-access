<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $navigationGroup = 'Facility Management';
    protected static ?int $navigationSort = 20;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Service Information')
                    ->description('Review service details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled(fn ($context) => $context === 'view'),

                                Select::make('category')
                                    ->options([
                                        'eMedSample' => 'eMedSample (Laboratory Tests)',
                                        'SharedBlood' => 'SharedBlood (Blood Donation)',
                                    ])
                                    ->disabled(fn ($context) => $context === 'view'),
                                
                                TextInput::make('price')
                                    ->label('Price (₦)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('₦')
                                    ->disabled(fn ($context) => $context === 'view'),

                                Select::make('availability_status')
                                    ->label('Availability')
                                    ->options([
                                        'available' => 'Available / In Stock',
                                        'unavailable' => 'Unavailable / Out of Stock',
                                        'limited' => 'Limited Availability',
                                    ])
                                    ->disabled(fn ($context) => $context === 'view'),

                                TextInput::make('turnaround_time')
                                    ->label('Turnaround Time')
                                    ->maxLength(50)
                                    ->disabled(fn ($context) => $context === 'view')
                                    ->visible(fn (callable $get) => $get('category') === 'eMedSample'),
                                    
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Pending Review',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required()
                                    ->default('pending'),
                                    
                                Forms\Components\Select::make('facility_id')
                                    ->relationship('facility', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->disabled(fn ($context) => $context === 'view'),
                            ]),
                    ]),

                Section::make('Requirements & Additional Information')
                    ->schema([
                        Textarea::make('requirements')
                            ->label('Requirements')
                            ->rows(3)
                            ->disabled(fn ($context) => $context === 'view'),
                        
                        Textarea::make('notes')
                            ->label('Additional Notes')
                            ->rows(3)
                            ->disabled(fn ($context) => $context === 'view'),
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
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('facility.name')
                    ->label('Facility')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('NGN')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'eMedSample',
                        'danger' => 'SharedBlood',
                    ]),
                
                Tables\Columns\BadgeColumn::make('availability_status')
                    ->colors([
                        'success' => 'available',
                        'danger' => 'unavailable',
                        'warning' => 'limited',
                    ]),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->date('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'eMedSample' => 'eMedSample (Laboratory Tests)',
                        'SharedBlood' => 'SharedBlood (Blood Donation)',
                    ]),
                    
                Tables\Filters\SelectFilter::make('facility')
                    ->relationship('facility', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Service $record): bool => $record->status === 'pending')
                    ->action(function (Service $record) {
                        $record->status = 'approved';
                        $record->save();
                        
                        Notification::make()
                            ->title('Service Approved')
                            ->body("The service '{$record->name}' has been approved.")
                            ->success()
                            ->send();
                    }),
                    
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Service $record): bool => $record->status === 'pending')
                    ->action(function (Service $record) {
                        $record->status = 'rejected';
                        $record->save();
                        
                        Notification::make()
                            ->title('Service Rejected')
                            ->body("The service '{$record->name}' has been rejected.")
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('approveSelected')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $count = 0;
                        foreach ($records as $record) {
                            if ($record->status === 'pending') {
                                $record->status = 'approved';
                                $record->save();
                                $count++;
                            }
                        }
                        
                        Notification::make()
                            ->title($count . ' Services Approved')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\BulkAction::make('rejectSelected')
                    ->label('Reject Selected')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        $count = 0;
                        foreach ($records as $record) {
                            if ($record->status === 'pending') {
                                $record->status = 'rejected';
                                $record->save();
                                $count++;
                            }
                        }
                        
                        Notification::make()
                            ->title($count . ' Services Rejected')
                            ->warning()
                            ->send();
                    }),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
