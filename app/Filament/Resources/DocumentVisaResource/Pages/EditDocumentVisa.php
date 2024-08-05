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

    // public function updatedActiveLocale(): void
    // {
    //     if (blank($this->oldActiveLocale)) {
    //         return;
    //     }

    //     $this->resetValidation();

    //     $translatableAttributes = static::getResource()::getTranslatableAttributes();

    //     // Fix part - Start
    //     $this->form->fill([
    //         ...Arr::except($this->data, $translatableAttributes),
    //         ...$this->otherLocaleData[$this->activeLocale] ?? [],
    //     ]);
    //     // // Fix part - End

    //     unset($this->otherLocaleData[$this->activeLocale]);
    // }
}
