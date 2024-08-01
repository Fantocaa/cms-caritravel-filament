<?php

namespace App\Filament\Resources\DocumentVisaResource\Pages;

use App\Filament\Resources\DocumentVisaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;

class EditDocumentVisa extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = DocumentVisaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
