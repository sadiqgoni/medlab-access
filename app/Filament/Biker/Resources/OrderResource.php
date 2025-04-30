<?php

namespace App\Filament\Biker\Resources;

use App\Filament\Biker\Resources\OrderResource\Pages;
use App\Filament\Biker\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'My Tasks';
    protected static ?int $navigationSort = 1;

    // Disable creation and deletion for Bikers
    public static function canCreate(): bool
    {
        return false;
    }

    // Scope queries to the logged-in biker
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('biker_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        // Biker form for viewing details and updating status/times
        return $form
            ->schema([
                Section::make('Task Details')
                    ->columns(2)
                    ->schema([
                         TextInput::make('id') // Show Order ID
                            ->label('Order ID')
                            ->disabled(),
                         Select::make('user_id') // Show Consumer
                            ->relationship('user', 'name')
                            ->label('Consumer')
                            ->disabled(),
                        Select::make('facility_id') // Show Facility
                            ->relationship('facility', 'name')
                            ->label('Facility')
                            ->disabled(),
                         Select::make('order_type')
                             ->options([
                                 'test' => 'Lab Test Sample Pickup/Delivery',
                                 'blood' => 'Blood Delivery/Pickup',
                             ])
                             ->disabled(),
                         Select::make('status') // Editable by Biker (limited statuses)
                             ->options([
                                 'sample_collected' => 'Sample Collected',
                                 'in_transit' => 'In Transit',
                                 'delivered' => 'Delivered',
                                 // Other statuses managed elsewhere
                             ])
                             ->required(),
                         Textarea::make('pickup_address')
                             ->rows(2)
                             ->label('Pickup Location')
                             ->disabled(),
                         Textarea::make('delivery_address')
                             ->rows(2)
                             ->label('Delivery Location')
                             ->disabled(),
                     ]),
                 Section::make('Timestamps')
                     ->columns(2)
                     ->schema([
                         DateTimePicker::make('pickup_scheduled_time')
                            ->label('Scheduled Pickup')->disabled(),
                         DateTimePicker::make('delivery_scheduled_time')
                             ->label('Scheduled Delivery')->disabled(),
                         DateTimePicker::make('actual_pickup_time') // Editable by Biker
                             ->label('Actual Pickup Time')
                             ->nullable(),
                         DateTimePicker::make('actual_delivery_time') // Editable by Biker
                             ->label('Actual Delivery Time')
                             ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
             // Query already scoped by getEloquentQuery
            ->columns([
                 TextColumn::make('id')->label('Order ID')->sortable(),
                 TextColumn::make('user.name')->label('Consumer')->searchable()->sortable()->toggleable(),
                 TextColumn::make('facility.name')->label('Facility')->searchable()->sortable()->toggleable(),
                 TextColumn::make('order_type')
                     ->badge()
                     ->formatStateUsing(fn (string $state): string => ucfirst($state))
                     ->color(fn (string $state): string => match ($state) {
                         'test' => 'info',
                         'blood' => 'danger',
                         default => 'gray',
                     })
                     ->toggleable(isToggledHiddenByDefault: true),
                 TextColumn::make('status')
                     ->badge()
                     ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                     ->color(fn (string $state): string => match ($state) {
                         'pending' => 'secondary', // Should rarely see this
                         'accepted' => 'warning', // Task Assigned
                         'sample_collected' => 'info',
                         'in_transit' => 'primary',
                         'delivered' => 'success',
                         'results_ready', 'completed' => 'gray', // Not biker's concern
                         'cancelled' => 'danger',
                         default => 'gray',
                     })
                     ->searchable()
                     ->sortable(),
                 TextColumn::make('pickup_address')->limit(25)->tooltip(fn (Order $record): string => $record->pickup_address)->toggleable(),
                 TextColumn::make('delivery_address')->limit(25)->tooltip(fn (Order $record): string => $record->delivery_address)->toggleable(),
                 TextColumn::make('pickup_scheduled_time')->dateTime('H:i')->label('Pickup Time')->sortable(),
                 TextColumn::make('delivery_scheduled_time')->dateTime('H:i')->label('Delivery Time')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                         'accepted' => 'Assigned',
                         'sample_collected' => 'Sample Collected',
                         'in_transit' => 'In Transit',
                         'delivered' => 'Delivered',
                         'cancelled' => 'Cancelled'
                    ]),
                 // Maybe filter by date?
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Allows status/time updates
                // Add ViewAction later?
            ])
            ->bulkActions([
                // No bulk actions needed for bikers
            ])
            ->defaultSort('pickup_scheduled_time', 'asc'); // Sort by upcoming pickup time
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
