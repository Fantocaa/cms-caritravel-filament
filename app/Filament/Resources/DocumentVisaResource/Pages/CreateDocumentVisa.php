<?php

namespace App\Filament\Resources\DocumentVisaResource\Pages;

use App\Filament\Resources\DocumentVisaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocumentVisa extends CreateRecord
{
    use CreateRecord\Concerns\Translatable;

    protected static string $resource = DocumentVisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
