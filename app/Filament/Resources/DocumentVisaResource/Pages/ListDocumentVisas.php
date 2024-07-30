<?php

namespace App\Filament\Resources\DocumentVisaResource\Pages;

use App\Filament\Resources\DocumentVisaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentVisas extends ListRecords
{
    use ListRecords\Concerns\Translatable;

    protected static string $resource = DocumentVisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
