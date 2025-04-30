<?php
namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('consumer_id')
                    ->relationship('consumer', 'name')
                    ->required(),
                Forms\Components\Select::make('facility_id')
                    ->relationship('facility', 'name')
                    ->default(null),
                Forms\Components\Select::make('biker_id')
                    ->relationship('biker', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('order_type')
                    ->required(),
                Forms\Components\Textarea::make('details')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Textarea::make('pickup_address')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('delivery_address')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('pickup_scheduled_time'),
                Forms\Components\DateTimePicker::make('delivery_scheduled_time'),
                Forms\Components\DateTimePicker::make('actual_pickup_time'),
                Forms\Components\DateTimePicker::make('actual_delivery_time'),
                Forms\Components\TextInput::make('payment_status')
                    ->required(),
                Forms\Components\TextInput::make('payment_method')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('payment_gateway_ref')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consumer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('facility.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('biker.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_type'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('pickup_scheduled_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('delivery_scheduled_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_pickup_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('actual_delivery_time')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_gateway_ref')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
