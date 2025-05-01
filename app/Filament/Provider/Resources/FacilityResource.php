<?php

namespace App\Filament\Provider\Resources;

use App\Filament\Provider\Resources\FacilityResource\Pages;
use App\Filament\Provider\Resources\FacilityResource\RelationManagers;
use App\Models\Facility;
use App\Models\Service; // Import Service model
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
use Filament\Forms\Components\CheckboxList; // Import CheckboxList
use Illuminate\Support\Facades\Http; // Import Http facade
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Arr; // Import Arr facade

class FacilityResource extends Resource
{
    protected static ?string $model = Facility::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationLabel = 'My Facility';
    protected static ?string $label = 'My Facility';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')->default(Auth::id()),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('address')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('contact_person')
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                CheckboxList::make('services') // Use CheckboxList for many-to-many
                    ->relationship('services', 'name') // Define relationship
                    ->label('Services Offered')
                    ->columns(2)
                    ->columnSpanFull(),
                // Latitude and Longitude will be set by the mutation
                // Status is likely set by Admin, not Provider initially
            ])
            ->mutateFormDataUsing(function (array $data): array {
                $mapboxToken = config('services.mapbox.token');
                $address = Arr::get($data, 'address');

                if (!empty($address) && $mapboxToken) {
                    try {
                        $response = Http::get("https://api.mapbox.com/geocoding/v5/mapbox.places/" . urlencode($address) . ".json", [
                            'access_token' => $mapboxToken,
                            'country' => 'NG',
                            'limit' => 1
                        ]);

                        if ($response->successful() && !empty($response->json('features'))) {
                            $coordinates = $response->json('features')[0]['center'];
                            $data['longitude'] = $coordinates[0];
                            $data['latitude'] = $coordinates[1];
                        } else {
                            Log::warning('Mapbox Geocoding failed for facility address:' . $address, ['response' => $response->body()]);
                        }
                    } catch (\Exception $e) {
                        Log::error('Mapbox Geocoding exception for facility:' . $e->getMessage());
                    }
                }
                
                // Ensure user_id is always set
                $data['user_id'] = Auth::id();
                // Default status for new facilities
                if (!isset($data['status'])) { // Only set default if not already set (e.g., during edit)
                    $data['status'] = 'pending'; 
                }

                return $data;
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
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
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\ServicesRelationManager::class, // Commented out for now
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacilities::route('/'),
            'create' => Pages\CreateFacility::route('/create'),
            'edit' => Pages\EditFacility::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        // Allow creation only if the provider doesn't already have a facility
        return !Facility::where('user_id', Auth::id())->exists();
    }
}
