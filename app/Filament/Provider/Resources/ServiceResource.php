<?php
namespace App\Filament\Provider\Resources;

use App\Filament\Provider\Resources\ServiceResource\Pages;
use App\Filament\Provider\Resources\ServiceResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Facility;
use App\Models\Service;
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
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Repeater;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

  
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Facility Management';

    public static function getEloquentQuery(): Builder
    {
        $facilityId = Facility::where('user_id', Auth::id())->value('id');
        
        return parent::getEloquentQuery()->where('facility_id', $facilityId);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Service Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₦')
                            ->default(0.00),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Service is Active'),
                    ]),
                    
                Section::make('Required Information Fields')
                    ->description('Define the fields consumers need to fill when ordering this service.')
                    ->schema([
                        Repeater::make('attributes')
                            ->label('Fields')
                            ->addActionLabel('Add Field')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Field Name (unique key, e.g., blood_group, sample_type)')
                                    ->required()
                                    ->distinct()
                                    ->maxLength(50),
                                TextInput::make('label')
                                    ->label('Field Label (shown to consumer)')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('type')
                                    ->options([
                                        'text' => 'Text Input',
                                        'number' => 'Number Input',
                                        'select' => 'Dropdown Select',
                                        'checkbox' => 'Checkbox',
                                        'textarea' => 'Text Area',
                                    ])
                                    ->required()
                                    ->reactive(),
                                Forms\Components\TagsInput::make('options')
                                    ->label('Dropdown Options (if type is Select)')
                                    ->placeholder('Enter options and press Enter')
                                    ->visible(fn (callable $get) => $get('type') === 'select'),
                                Toggle::make('required')
                                    ->default(true),
                            ])
                            ->columns(2)
                            ->collapsible()
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),

                // Automatically set facility_id
                Forms\Components\Hidden::make('facility_id')
                    ->default(fn () => Facility::where('user_id', Auth::id())->value('id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                // TextColumn::make('description') 
                //    ->limit(30)
                //    ->tooltip(fn (?string $state): ?string => $state)
                //    ->toggleable(),
                TextColumn::make('price')
                    ->money('NGN')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                // TextColumn::make('attributes') 
                //    ->label('# Fields')
                //    ->getStateUsing(fn (?array $state) => count($state ?? [])),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                 Tables\Filters\TernaryFilter::make('is_active')
                     ->label('Status'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
