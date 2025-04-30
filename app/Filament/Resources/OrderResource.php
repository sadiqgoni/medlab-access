<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 3; // Position after Facilities

    // Disable creation for Admins
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        // Admin form is mostly for viewing/editing specific fields like status or biker
        return $form
            ->schema([
                Section::make('Order Information')
                    ->columns(3)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Consumer')
                            ->disabled(),
                        Select::make('facility_id')
                            ->relationship('facility', 'name')
                            ->label('Facility')
                            ->disabled(),
                        Select::make('order_type')
                            ->options([
                                'test' => 'Lab Test',
                                'blood' => 'Blood Request/Donation',
                            ])
                            ->disabled(),
                        Select::make('status') // Editable by Admin
                            ->options([
                                'pending' => 'Pending',
                                'accepted' => 'Accepted',
                                'processing' => 'Processing',
                                'sample_collected' => 'Sample Collected',
                                'in_transit' => 'In Transit',
                                'delivered' => 'Delivered',
                                'results_ready' => 'Results Ready',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled'
                            ])
                            ->required(),
                        Select::make('biker_id') // Assign Biker
                            ->relationship('biker', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('role', 'biker'))
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Assigned Biker'),
                        KeyValue::make('details')
                            ->columnSpanFull()
                            ->label('Order Details')
                            ->disabled(),
                    ]),
                Section::make('Logistics')
                    ->columns(2)
                    ->schema([
                        Textarea::make('pickup_address')->disabled(),
                        Textarea::make('delivery_address')->disabled(),
                        DateTimePicker::make('pickup_scheduled_time')->disabled(),
                        DateTimePicker::make('delivery_scheduled_time')->disabled(),
                        DateTimePicker::make('actual_pickup_time')->disabled(), // Should be updated by Biker
                        DateTimePicker::make('actual_delivery_time')->disabled(), // Should be updated by Biker
                    ]),
                Section::make('Payment')
                    ->columns(3)
                    ->schema([
                        Select::make('payment_status')
                             ->options([
                                 'pending' => 'Pending',
                                 'paid' => 'Paid',
                                 'failed' => 'Failed',
                             ])
                             ->disabled(), // Or editable depending on workflow
                        TextInput::make('payment_method')->disabled(),
                        TextInput::make('total_amount')
                            ->numeric()
                            ->prefix('₦') // Add Naira prefix
                            ->disabled(),
                        TextInput::make('payment_gateway_ref')
                            ->label('Payment Ref')
                            ->columnSpanFull()
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Order ID')->sortable(),
                TextColumn::make('user.name')->label('Consumer')->searchable()->sortable(),
                TextColumn::make('facility.name')->label('Facility')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('biker.name')->label('Biker')->searchable()->sortable()->placeholder('N/A'),
                TextColumn::make('order_type')
                    ->badge()
                     ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'test' => 'info',
                        'blood' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted', 'processing', 'sample_collected', 'in_transit', 'delivered' => 'info',
                        'results_ready' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_status')
                     ->badge()
                     ->formatStateUsing(fn (string $state): string => ucfirst($state))
                     ->color(fn (string $state): string => match ($state) {
                         'pending' => 'warning',
                         'paid' => 'success',
                         'failed' => 'danger',
                         default => 'gray',
                     })
                     ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_amount')
                    ->money('NGN') // Format as currency
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->label('Ordered On'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'processing' => 'Processing',
                        'sample_collected' => 'Sample Collected',
                        'in_transit' => 'In Transit',
                        'delivered' => 'Delivered',
                        'results_ready' => 'Results Ready',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled'
                    ]),
                SelectFilter::make('order_type')
                    ->options([
                        'test' => 'Lab Test',
                        'blood' => 'Blood Request/Donation',
                    ]),
                 SelectFilter::make('payment_status')
                     ->options([
                         'pending' => 'Pending',
                         'paid' => 'Paid',
                         'failed' => 'Failed',
                     ]),
                 Filter::make('created_at') // Date range filter
                     ->form([
                         Forms\Components\DatePicker::make('created_from'),
                         Forms\Components\DatePicker::make('created_until'),
                     ])
                     ->query(function (Builder $query, array $data): Builder {
                         return $query
                             ->when(
                                 $data['created_from'],
                                 fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                             )
                             ->when(
                                 $data['created_until'],
                                 fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                             );
                     })
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Keep edit for status/biker updates
                // Add ViewAction later for more detail?
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(), // Disable bulk delete for orders
                ]),
            ])
            ->defaultSort('created_at', 'desc'); // Sort by newest first
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
