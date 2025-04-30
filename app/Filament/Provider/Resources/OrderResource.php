<?php

namespace App\Filament\Provider\Resources;

use App\Filament\Provider\Resources\OrderResource\Pages;
use App\Filament\Provider\Resources\OrderResource\RelationManagers;
use App\Models\Order;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\FileUpload;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 1; // Position before My Facility

    // Disable creation and deletion for Providers
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
        // Provider form is mostly read-only, allowing status/biker updates
        return $form
            ->schema([
                 Section::make('Order Information')
                    ->columns(3)
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Consumer')
                            ->disabled(),
                        // Facility is implicitly the provider's own, hide field
                        // Select::make('facility_id') ... 
                        Select::make('order_type')
                            ->options([
                                'test' => 'Lab Test',
                                'blood' => 'Blood Request/Donation',
                            ])
                            ->disabled(),
                        Select::make('status') // Editable by Provider (limited options maybe?)
                            ->options([
                                // 'pending' => 'Pending', // Provider shouldn't set this
                                'accepted' => 'Accept Order', // Allow accepting
                                'processing' => 'Processing',
                                'results_ready' => 'Results Ready',
                                'cancelled' => 'Cancel Order'
                                // Other statuses updated by Biker/System
                            ])
                            ->required(),
                        Select::make('biker_id') // Allow assigning Biker
                            ->relationship('biker', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('role', 'biker'))
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->label('Assign Biker'), // Maybe only show available bikers?
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
                        DateTimePicker::make('actual_pickup_time')->disabled(),
                        DateTimePicker::make('actual_delivery_time')->disabled(),
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
                             ->disabled(),
                        TextInput::make('payment_method')->disabled(),
                        TextInput::make('total_amount')->numeric()->prefix('₦')->disabled(),
                        TextInput::make('payment_gateway_ref')->label('Payment Ref')->columnSpanFull()->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Query already scoped by getEloquentQuery
            ->columns([
                 TextColumn::make('id')->label('Order ID')->sortable(),
                 TextColumn::make('user.name')->label('Consumer')->searchable()->sortable(),
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
                TextColumn::make('created_at')
                     ->dateTime('M d, Y H:i')
                     ->sortable()
                     ->label('Ordered On'),
            ])
            ->filters([
                 SelectFilter::make('status') // Still useful for provider
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'processing' => 'Processing',
                        'results_ready' => 'Results Ready',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled'
                    ]),
                 SelectFilter::make('order_type')
                    ->options([
                        'test' => 'Lab Test',
                        'blood' => 'Blood Request/Donation',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Allows status/biker updates
                Action::make('enterResults')
                    ->label('Enter Results')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    // Only show for test orders in processing status
                    ->visible(fn (Order $record): bool => $record->order_type === 'test' && $record->status === 'processing') 
                    ->action(function (Order $record, array $data): void {
                        // Save results data (e.g., in details or a dedicated field/relation)
                        $record->details = array_merge($record->details ?? [], ['results' => $data['result_notes'], 'result_file' => $data['result_file'] ?? null]);
                        $record->status = 'results_ready';
                        $record->save();
                        // TODO: Trigger notification to consumer
                    })
                    ->modalHeading('Enter Test Results')
                    ->modalSubmitActionLabel('Save Results & Notify Consumer')
                    ->form([
                        Textarea::make('result_notes')
                            ->label('Result Notes / Summary')
                            ->required()
                            ->rows(10)
                            ->placeholder('Enter detailed test results here...'),
                        FileUpload::make('result_file')
                            ->label('Upload Result PDF (Optional)')
                            ->disk('public') // Ensure you have a 'public' disk configured in filesystems.php
                            ->directory('order-results') 
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(5120), // Max 5MB
                    ])
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
            // 'create' => Pages\CreateOrder::route('/create'), // Disabled
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
