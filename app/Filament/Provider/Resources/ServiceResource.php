<?php

namespace App\Filament\Provider\Resources;

use App\Filament\Provider\Resources\ServiceResource\Pages;
use App\Filament\Provider\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Services';
    protected static ?string $navigationGroup = 'Service Management';
    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Service Details')
                    ->description('Define the basic details of your service')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Malaria Test, Blood Type A+')
                                    ->autofocus(),

                                Select::make('category')
                                    ->required()
                                    ->options([
                                        'eMedSample' => 'eMedSample (Laboratory Tests)',
                                        'SharedBlood' => 'SharedBlood (Blood Donation)',
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'eMedSample') {
                                            $set('availability_status', 'available');
                                        }
                                    }),
                                
                                TextInput::make('price')
                                    ->label('Price (₦)')
                                    ->required()
                                    ->numeric()
                                    ->prefix('₦')
                                    ->placeholder('e.g., 5000'),

                                Select::make('availability_status')
                                    ->label('Availability')
                                    ->options([
                                        'available' => 'Available / In Stock',
                                        'unavailable' => 'Unavailable / Out of Stock',
                                        'limited' => 'Limited Availability',
                                    ])
                                    ->default('available')
                                    ->required(),

                                TextInput::make('turnaround_time')
                                    ->label('Turnaround Time')
                                    ->placeholder('e.g., 24 hours, Same day')
                                    ->maxLength(50)
                                    ->visible(fn (callable $get) => $get('category') === 'eMedSample'),
                            ]),
                    ]),

                Section::make('Requirements & Additional Information')
                    ->description('Provide any special requirements or additional information')
                    ->schema([
                        Textarea::make('requirements')
                            ->label('Requirements')
                            ->placeholder('e.g., Fasting required, Early morning sample needed')
                            ->helperText('Specify any prerequisites patients should know before ordering')
                            ->rows(3),
                        
                        Textarea::make('notes')
                            ->label('Additional Notes')
                            ->placeholder('e.g., Results delivered via PDF, Blood screening completed')
                            ->helperText('Any additional information about this service')
                            ->rows(3),
                    ]),

                Forms\Components\Hidden::make('facility_id')
                    ->default(function () {
                        $user = Auth::user();
                        return $user->facility_id ?? null;
                    }),

                Forms\Components\Hidden::make('status')
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Service $record): string => $record->category),
                
                TextColumn::make('price')
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
                    ])
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),
                
                TextColumn::make('turnaround_time')
                    ->label('Turnaround')
                    ->toggleable(isToggledHiddenByDefault: false),
                
                TextColumn::make('created_at')
                    ->label('Added on')
                    ->date('M d, Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->options([
                        'eMedSample' => 'eMedSample (Laboratory Tests)',
                        'SharedBlood' => 'SharedBlood (Blood Donation)',
                    ]),
                
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Approval',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                
                SelectFilter::make('availability_status')
                    ->options([
                        'available' => 'Available / In Stock',
                        'unavailable' => 'Unavailable / Out of Stock',
                        'limited' => 'Limited Availability',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Service $record) => $record->status === 'pending'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Filter services to only those belonging to the provider's facility
        $query = parent::getEloquentQuery();
        
        $user = auth()->user();
        if ($user && $user->facility_id) {
            $query->where('facility_id', $user->facility_id);
        }
        
        return $query;
    }
}
