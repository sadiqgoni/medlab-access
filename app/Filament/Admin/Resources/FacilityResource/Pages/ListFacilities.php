<?php

namespace App\Filament\Admin\Resources\FacilityResource\Pages;

use App\Filament\Admin\Resources\FacilityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacilities extends ListRecords
{
    protected static string $resource = FacilityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
