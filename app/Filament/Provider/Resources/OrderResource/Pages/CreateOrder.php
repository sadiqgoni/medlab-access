<?php

namespace App\Filament\Provider\Resources\OrderResource\Pages;

use App\Filament\Provider\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
