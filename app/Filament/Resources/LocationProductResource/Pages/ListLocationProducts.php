<?php

namespace App\Filament\Resources\LocationProductResource\Pages;

use App\Filament\Resources\LocationProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLocationProducts extends ListRecords
{
    protected static string $resource = LocationProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
