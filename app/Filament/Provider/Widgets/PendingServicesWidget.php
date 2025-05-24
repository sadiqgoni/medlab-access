<?php

namespace App\Filament\Provider\Widgets;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingServicesWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Pending Service Approvals';
    protected static ?int $sort = 20;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Service::query()
                    ->where('facility_id', Auth::user()->facility_id)
                    ->where('status', 'pending')
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),
                
                Tables\Columns\BadgeColumn::make('category')
                    ->colors([
                        'primary' => 'eMedSample',
                        'danger' => 'SharedBlood',
                    ]),
                
                Tables\Columns\TextColumn::make('price')
                    ->money('NGN')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime('M d, Y g:i A')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->url(fn (Service $record): string => route('filament.provider.resources.services.edit', $record))
                    ->icon('heroicon-s-eye')
                    ->tooltip('View/Edit Service'),
            ])
            ->emptyStateIcon('heroicon-o-clipboard-document-check')
            ->emptyStateHeading('No Pending Services')
            ->emptyStateDescription('All your services have been approved or you haven\'t submitted any yet.')
            ->emptyStateActions([
                Tables\Actions\Action::make('create')
                    ->label('Add Service')
                    ->url(route('filament.provider.resources.services.create'))
                    ->icon('heroicon-o-plus')
                    ->button(),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([5]);
    }
}
