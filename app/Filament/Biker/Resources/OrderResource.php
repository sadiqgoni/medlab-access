<?php

namespace App\Filament\Biker\Resources;

use App\Filament\Biker\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action as TableAction;
use Carbon\Carbon;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'My Deliveries';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Delivery Task';
    protected static ?string $pluralModelLabel = 'Delivery Tasks';
    protected static ?string $recordTitleAttribute = 'id';

    // Disable creation for Bikers
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
        return $form
            ->schema([
                Section::make('Delivery Task Status')
                    ->description('Update the status of your delivery task')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Select::make('status')
                                    ->label('Current Status')
                                    ->options([
                                        'accepted' => 'Task Assigned',
                                        'sample_collected' => 'Sample Collected',
                                        'in_transit' => 'In Transit',
                                        'delivered' => 'Delivered',
                                    ])
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'sample_collected') {
                                            $set('actual_pickup_time', now());
                                        } elseif ($state === 'delivered') {
                                            $set('actual_delivery_time', now());
                                        }
                                    }),
                            ]),
                    ]),

                Section::make('Task Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('id')
                                    ->label('Order #')
                                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                                    ->disabled(),

                                Select::make('order_type')
                                    ->label('Task Type')
                                    ->options([
                                        'test' => 'Lab Test Sample',
                                        'blood' => 'Blood Delivery',
                                    ])
                                    ->disabled()
                                    ->formatStateUsing(function ($state) {
                                        return match($state) {
                                            'test' => 'Lab Test Sample',
                                            'blood' => 'Blood Delivery',
                                            default => $state
                                        };
                                    })
                                    ->reactive(),

                                ViewField::make('customer_info')
                                    ->label('Customer Information')
                                    ->view('biker.partials.customer-info'),

                                ViewField::make('facility_info')
                                    ->label('Facility Information')
                                    ->view('biker.partials.facility-info'),
                            ]),
                    ]),

                Section::make('Delivery Locations')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Card::make()
                                    ->schema([
                                        Textarea::make('delivery_address')
                                            ->label(function ($record) { 
                                                if (!$record) return 'Pickup Location';
                                                return $record->order_type === 'test' ? 'Sample Pickup Location' : 'Blood Pickup Location';
                                            })
                                            // ->state(function ($record) {
                                            //     // For test orders: pickup is at customer location
                                            //     // For blood orders: pickup is at facility location
                                            //     if (!$record) return null; // Added null check
                                            //     if ($record->order_type === 'test') {
                                            //         return $record->delivery_address; // Customer's address
                                            //     } else {
                                            //         return $record->pickup_address; // Facility address for blood
                                            //     }
                                            // })
                                            ->disabled()
                                            ->rows(3),
                                            
                                        DateTimePicker::make('pickup_scheduled_time')
                                            ->label('Scheduled Pickup')
                                            ->displayFormat('M j, Y - g:i A')
                                            ->disabled(),
                                            
                                        DateTimePicker::make('actual_pickup_time')
                                            ->label('Actual Pickup Time')
                                            ->displayFormat('M j, Y - g:i A')
                                            ->placeholder('Record when pickup is completed')
                                            ->reactive()
                                            ->disabled(function ($get) {
                                                return !in_array($get('status'), ['sample_collected', 'in_transit', 'delivered']);
                                            }),
                                    ])
                                    ->columns(1),
                                    
                                Card::make()
                                    ->schema([
                                        Textarea::make('delivery_address')
                                            ->label(function ($record) { // Changed from $get to $record
                                                if (!$record) return 'Delivery Location'; // Added null check
                                                return $record->order_type === 'test' ? 'Lab Sample Delivery Location' : 'Blood Delivery Location';
                                            })
                                            // ->state(function ($record) {
                                            //     // For test orders: delivery is to facility location
                                            //     // For blood orders: delivery is to customer location
                                            //     if (!$record) return null; // Added null check
                                            //     if ($record->order_type === 'test') {
                                            //         return $record->pickup_address; // Facility address
                                            //     } else {
                                            //         return $record->delivery_address; // Customer's address
                                            //     }
                                            // })
                                            ->disabled()
                                            ->rows(3),
                                            
                                        DateTimePicker::make('delivery_scheduled_time')
                                            ->label('Expected Delivery')
                                            ->displayFormat('M j, Y - g:i A')
                                            ->disabled(),
                                            
                                        DateTimePicker::make('actual_delivery_time')
                                            ->label('Actual Delivery Time')
                                            ->displayFormat('M j, Y - g:i A')
                                            ->placeholder('Record when delivery is completed')
                                            ->reactive()
                                            ->disabled(function ($get) {
                                                return $get('status') !== 'delivered';
                                            }),
                                    ])
                                    ->columns(1),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'accepted' => 'Assigned',
                        'sample_collected' => 'Collected',
                        'in_transit' => 'In Transit',
                        'delivered' => 'Delivered',
                        default => ucwords(str_replace('_', ' ', $state))
                    })
                    ->colors([
                        'warning' => 'accepted',
                        'info' => 'sample_collected',
                        'primary' => 'in_transit',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->sortable(),
                    
                TextColumn::make('id')
                    ->label('Order #')
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->sortable(),
                    
                IconColumn::make('order_type')
                    ->label('Type')
                    ->alignCenter()
                    ->tooltip(fn (string $state): string => match ($state) {
                        'test' => 'Lab Test Sample',
                        'blood' => 'Blood Delivery',
                        default => 'Unknown',
                    })
                    ->options([
                        'heroicon-o-beaker' => 'test',
                        'heroicon-o-heart' => 'blood',
                    ]),
                    
                TextColumn::make('facility.name')
                    ->label('Facility')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                    
                TextColumn::make('consumer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                    
                TextColumn::make('pickup_scheduled_time')
                    ->label('Pickup')
                    ->date('h:i A')
                    ->sortable()
                    ->tooltip(fn(Order $record): string => 
                        Carbon::parse($record->pickup_scheduled_time)->format('M j, Y - g:i A')
                    ),
                
                TextColumn::make('delivery_scheduled_time')
                    ->label('Delivery')
                    ->date('h:i A')
                    ->sortable()
                    ->tooltip(fn(Order $record): string => 
                        Carbon::parse($record->delivery_scheduled_time)->format('M j, Y - g:i A')
                    ),
                    
                TextColumn::make('distance')
                    ->label('Distance')
                    ->formatStateUsing(function ($state, Order $record) {
                        // Placeholder for real distance calculation
                        return '~3.2 km';
                    })
                    ->sortable(false),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'accepted' => 'Assigned',
                        'sample_collected' => 'Collected',
                        'in_transit' => 'In Transit',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled'
                    ]),
                    // ->indicator(),
                    
                SelectFilter::make('order_type')
                    ->options([
                        'test' => 'Lab Test',
                        'blood' => 'Blood Service',
                    ]),
                    // ->indicator(),
                    
                Filter::make('today')
                    ->label('Today\'s Deliveries')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', Carbon::today()))
                    ->toggle(),
            ])
            ->actions([
                TableAction::make('view_route')
                    ->label('View Route')
                    ->icon('heroicon-o-map')
                    ->color('primary')
                    ->url(fn (Order $record): string => route('biker.map-route', $record))
                    ->openUrlInNewTab(),
                    
                TableAction::make('update_status')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->url(fn (Order $record): string => route('filament.biker.resources.orders.edit', $record))
                    ->hidden(fn (Order $record): bool => $record->status === 'delivered' || $record->status === 'cancelled'),
                    
                TableAction::make('call_customer')
                    ->label('Call Customer')
                    ->icon('heroicon-o-phone')
                    ->color('info')
                    ->url(fn (Order $record): string => 'tel:' . ($record->consumer->phone ?? ''))
                    ->hidden(fn (Order $record): bool => empty($record->consumer->phone))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                // No bulk actions needed for bikers
            ])
            ->defaultSort('pickup_scheduled_time', 'asc'); // Show upcoming pickups first
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
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
