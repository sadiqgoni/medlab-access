<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Filament\Tables\Filters\SelectFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                Forms\Components\Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'provider' => 'Service Provider',
                        'biker' => 'DHR Biker',
                        'consumer' => 'Consumer',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->maxLength(1000)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('government_id')
                    ->label('Government ID')
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                Forms\Components\Select::make('blood_group')
                     ->options([
                        'A+' => 'A+',
                        'A-' => 'A-',
                        'B+' => 'B+',
                        'B-' => 'B-',
                        'AB+' => 'AB+',
                        'AB-' => 'AB-',
                        'O+' => 'O+',
                        'O-' => 'O-',
                     ])
                     ->nullable(),
                Forms\Components\Checkbox::make('eligible_donor')
                    ->label('Eligible Blood Donor?')
                    ->default(false),
                Forms\Components\Select::make('communication_preference')
                    ->options([
                        'email' => 'Email',
                        'sms' => 'SMS',
                        'app' => 'App Notification',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                    ->confirmed(fn (string $context): bool => $context === 'create')
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->visibleOn('create')
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'provider' => 'warning',
                        'biker' => 'success',
                        'consumer' => 'info',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\IconColumn::make('eligible_donor')
                    ->label('Donor?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('blood_group')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('government_id')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('communication_preference')
                    ->toggleable(isToggledHiddenByDefault: true),
                 Tables\Columns\TextColumn::make('email_verified_at')
                     ->dateTime()
                     ->sortable()
                     ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'provider' => 'Service Provider',
                        'biker' => 'DHR Biker',
                        'consumer' => 'Consumer',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
