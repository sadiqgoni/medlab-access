<?php

namespace App\Filament\Provider\Resources;

use App\Filament\Provider\Resources\OrderResource\Pages;
use App\Filament\Provider\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ActionGroup;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 1; // Position before other items
    protected static ?string $navigationLabel = 'Order Management';
    protected static ?string $recordTitleAttribute = 'id';

    // Disable creation for Providers
    public static function canCreate(): bool
    {
        return false;
    }

    // Scope queries to the logged-in provider's facility
    public static function getEloquentQuery(): Builder
    {
        // Get the facility ID associated with the current provider user
        $facilityId = Facility::where('user_id', Auth::id())->value('id');
        
        // Return orders associated with that facility ID
        return parent::getEloquentQuery()->where('facility_id', $facilityId);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Order Details')
                    ->tabs([
                        Tabs\Tab::make('Order Information')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Section::make('Order Overview')
                                    ->description('Basic information about this order')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('id')
                                                    ->label('Order #')
                                                    ->disabled()
                                                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT)),
                                                
                                                Select::make('consumer_id')
                                                    ->relationship('consumer', 'name')
                                                    ->label('Customer')
                                                    ->disabled()
                                                    ->searchable()
                                                    ->columnSpan(1),
                                                
                                                Select::make('order_type')
                                                    ->options([
                                                        'test' => 'Laboratory Test',
                                                        'blood' => 'Blood Service',
                                                    ])
                                                    ->disabled()
                                                    // ->icon(fn (string $state): string => match ($state) {
                                                    //     'test' => 'heroicon-o-beaker',
                                                    //     'blood' => 'heroicon-o-heart',
                                                    //     default => 'heroicon-o-question-mark-circle',
                                                    // }),
                                            ]),
                                            
                                        Grid::make(1)
                                            ->schema([
                                                Placeholder::make('created_at')
                                                    ->label('Order Placed')
                                                    ->content(fn (Order $record): string => $record->created_at?->format('F j, Y, g:i a') ?? 'N/A'),
                                            ]),
                                    ]),
                                    
                                Section::make('Order Details')
                                    ->description('Details about the services ordered')
                                    ->collapsible()
                                    ->schema([
                                        ViewField::make('services')
                                            ->label('Ordered Services')
                                            ->view('provider.partials.order-services-list'),
                                            
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('total_amount')
                                                    ->label('Order Total')
                                                    ->prefix('₦')
                                                    ->disabled(),
                                                
                                                Placeholder::make('payment_info')
                                                    ->label('Payment Status')
                                                    ->content(fn (Order $record): string => ucfirst($record->payment_status ?? 'pending') . 
                                                        ($record->payment_method ? ' - via ' . ucfirst($record->payment_method) : '')),
                                            ]),
                                            
                                        Textarea::make('test_notes')
                                            ->label('Customer Notes')
                                            ->placeholder('No notes provided')
                                            ->disabled()
                                            ->rows(2)
                                            ->formatStateUsing(fn ($state, $record) => $record->details['test_notes'] ?? null)
                                            ->visible(fn ($record) => isset($record->details['test_notes']))
                                    ]),
                                    
                                Section::make('Order Management')
                                    ->description('Manage this order')
                                    ->schema([
                                        Radio::make('status')
                                            ->label('Order Status')
                                            ->options([
                                                'pending' => 'Pending Review',
                                                'accepted' => 'Accept Order',
                                                'processing' => 'In Processing',
                                                'results_ready' => 'Results Ready',
                                                'completed' => 'Completed',
                                                'cancelled' => 'Cancel Order',
                                            ])
                                            ->descriptions([
                                                'pending' => 'Order is awaiting your review',
                                                'accepted' => 'Accept and start processing this order',
                                                'processing' => 'Order is being processed at your facility',
                                                'results_ready' => 'Test results are ready for customer',
                                                'completed' => 'Order has been fully completed',
                                                'cancelled' => 'Cancel this order (will notify customer)',
                                            ])
                                            ->inline()
                                            ->required(),
                                        
                                        Fieldset::make('Assign a Delivery Person')
                                            ->schema([
                                                Select::make('biker_id') 
                                                    ->relationship('biker', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('role', 'biker'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->placeholder('Select a delivery person for pickup/delivery')
                                                    ->nullable()
                                                    ->label('Delivery Person')
                                                    ->helperText('This person will handle sample pickup and/or result delivery'),
                                                    
                                                DateTimePicker::make('pickup_scheduled_time')
                                                    ->label('Schedule Pickup')
                                                    ->placeholder('When should the pickup happen?')
                                                    ->seconds(false),
                                                    // ->minutesStep(15),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Logistics & Addresses')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Fieldset::make('Customer Information')
                                            ->schema([
                                                Textarea::make('delivery_address')
                                                    ->label('Customer Address')
                                                    ->disabled()
                                                    ->rows(3),
                                                    
                                                Placeholder::make('customer_contact')
                                                    ->label('Customer Contact')
                                                    ->content(function (Order $record): string {
                                                        $consumer = User::find($record->consumer_id);
                                                        if (!$consumer) return 'N/A';
                                                        
                                                        return $consumer->phone ?? 'No phone number' . 
                                                            '<br>' . ($consumer->email ?? 'No email');
                                                    })
                                                    ->columnSpan(1),
                                            ]),
                                            
                                        Fieldset::make('Delivery Tracking')
                                            ->schema([
                                                DateTimePicker::make('actual_pickup_time')
                                                    ->label('Actual Pickup Time')
                                                    ->placeholder('When was the sample picked up?')
                                                    ->seconds(false),
                                                    
                                                DateTimePicker::make('actual_delivery_time')
                                                    ->label('Delivery Completion Time')
                                                    ->placeholder('When was delivery completed?')
                                                    ->seconds(false),
                                                    
                                                Placeholder::make('delivery_status')
                                                    ->label('Delivery Status')
                                                    ->content(function (Order $record): string {
                                                        if (!$record->biker_id) {
                                                            return '<span class="text-gray-500">No delivery person assigned</span>';
                                                        }
                                                        
                                                        if ($record->actual_delivery_time) {
                                                            return '<span class="text-green-500">Delivery completed</span>';
                                                        }
                                                        
                                                        if ($record->actual_pickup_time) {
                                                            return '<span class="text-blue-500">In transit</span>';
                                                        }
                                                        
                                                        if ($record->biker_id) {
                                                            return '<span class="text-orange-500">Delivery assigned</span>';
                                                        }
                                                        
                                                        return 'Unknown';
                                                    })->columnSpan(2),
                                            ]),
                                    ]),
                            ]),
                            
                        Tabs\Tab::make('Test Results')
                            ->icon('heroicon-o-document-text')
                            ->visible(fn (Order $record): bool => $record->order_type === 'test')
                            ->schema([
                                Section::make('Test Results Management')
                                    ->description('Enter and manage test results for the customer')
                                    ->schema([
                                        Textarea::make('result_notes')
                                            ->label('Result Summary')
                                            ->placeholder('Enter detailed test results here...')
                                            ->rows(7)
                                            ->formatStateUsing(fn ($state, $record) => $record->details['results'] ?? null),
                                            
                                        FileUpload::make('result_file')
                                            ->label('Upload Result PDF')
                                            ->disk('public')
                                            ->directory('order-results')
                                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                                            ->maxSize(5120)
                                            ->helperText('Upload PDF reports or images (max 5MB)')
                                            ->formatStateUsing(fn ($state, $record) => $record->details['result_file'] ?? null),
                                        
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('notify_customer')
                                                    ->label('Notify Customer')
                                                    ->helperText('Send notification to customer about results')
                                                    ->default(true),
                                                    
                                                Placeholder::make('result_status')
                                                    ->label('Results Status')
                                                    ->content(function (Order $record): string {
                                                        if (isset($record->details['results'])) {
                                                            return '<span class="text-green-500">Results already entered</span>';
                                                        }
                                                        return '<span class="text-gray-500">No results entered yet</span>';
                                                    }),
                                            ]),
                                        
                                        Placeholder::make('save_results_info')
                                            ->content('Click "Save" after entering results to update the order status automatically. This will make results available to the customer.')
                                            ->columnSpan(2),
                                    ]),
                            ]),
                    ])
                    ->activeTab(0) // Assuming 'Order Information' is the first tab
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order #')
                    ->formatStateUsing(fn ($state) => '#' . str_pad($state, 6, '0', STR_PAD_LEFT))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                TextColumn::make('consumer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                
                IconColumn::make('order_type')
                    ->label('Type')
                    ->alignCenter()
                    ->tooltip(fn (string $state): string => match ($state) {
                        'test' => 'Laboratory Test',
                        'blood' => 'Blood Service',
                        default => 'Unknown',
                    })
                    ->options([
                        'heroicon-o-beaker' => 'test',
                        'heroicon-o-heart' => 'blood',
                    ]),
                
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => ucwords(str_replace('_', ' ', $state)))
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'accepted',
                        'primary' => 'processing',
                        'success' => 'results_ready',
                        'gray' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                
                TextColumn::make('biker.name')
                    ->label('Delivery Person')
                    ->placeholder('Not assigned')
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('total_amount')
                    ->label('Amount')
                    ->money('NGN')
                    ->alignRight()
                    ->sortable(),
                
                BadgeColumn::make('payment_status')
                    ->label('Payment')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                    ])
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'processing' => 'Processing',
                        'results_ready' => 'Results Ready',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled'
                    ])
                    ->placeholder('All Statuses'),
                    // ->indicator(),
                    
                SelectFilter::make('order_type')
                    ->options([
                        'test' => 'Laboratory Test',
                        'blood' => 'Blood Service',
                    ])
                    ->placeholder('All Types'),
                    // ->indicator(),
                    
                Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
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
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['created_from'] ?? null) {
                            $indicators['created_from'] = 'Order from ' . Carbon\Carbon::parse($data['created_from'])->toFormattedDateString();
                        }
                        
                        if ($data['created_until'] ?? null) {
                            $indicators['created_until'] = 'Order until ' . Carbon\Carbon::parse($data['created_until'])->toFormattedDateString();
                        }
                        
                        return $indicators;
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    TableAction::make('view')
                        ->label('View Details')
                        ->icon('heroicon-o-eye')
                        ->url(fn (Order $record): string => route('filament.provider.resources.orders.edit', $record))
                        ->openUrlInNewTab(false),
                        
                    TableAction::make('accept')
                        ->label('Accept Order')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (Order $record): void {
                            $record->update(['status' => 'accepted']);
                        })
                        ->visible(fn (Order $record): bool => $record->status === 'pending'),
                        
                    TableAction::make('process')
                        ->label('Process Order')
                        ->icon('heroicon-o-beaker')
                        ->color('primary')
                        ->action(function (Order $record): void {
                            $record->update(['status' => 'processing']);
                        })
                        ->visible(fn (Order $record): bool => $record->status === 'accepted'),
                        
                    TableAction::make('enter_results')
                        ->label('Enter Results')
                        ->icon('heroicon-o-document-text')
                        ->color('success')
                        ->url(fn (Order $record): string => route('filament.provider.resources.orders.edit', $record) . '?activeTab=test-results')
                        ->openUrlInNewTab(false)
                        ->visible(fn (Order $record): bool => $record->order_type === 'test' && in_array($record->status, ['processing', 'accepted'])),
                    
                    TableAction::make('cancel')
                        ->label('Cancel')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Order $record): void {
                            $record->update(['status' => 'cancelled']);
                        })
                        ->visible(fn (Order $record): bool => in_array($record->status, ['pending', 'accepted'])),
                ])
                ->label('Actions')
                ->icon('heroicon-s-chevron-down')
                ->button()
                ->color('gray'),
            ])
            ->bulkActions([
                // No bulk actions for provider
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
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
