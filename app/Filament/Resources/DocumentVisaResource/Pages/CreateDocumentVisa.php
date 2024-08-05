<?php

namespace App\Filament\Resources\DocumentVisaResource\Pages;

use App\Filament\Resources\DocumentVisaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

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

    // public function updatedActiveLocale(): void
    // {
    //     if (blank($this->oldActiveLocale)) {
    //         return;
    //     }

    //     $this->resetValidation();

    //     $translatableAttributes = static::getResource()::getTranslatableAttributes();

    //     // Clear translatable fields and keep other fields intact
    //     $this->form->fill([
    //         'country' => $this->data['country'] ?? null, // Keep country as is
    //         'categories' => array_map(function ($category) use ($translatableAttributes) {
    //             return array_filter($category, fn ($key) => in_array($key, $translatableAttributes), ARRAY_FILTER_USE_KEY);
    //         }, $this->data['categories'] ?? []),
    //         ...$this->otherLocaleData[$this->activeLocale] ?? [],
    //     ]);

    //     unset($this->otherLocaleData[$this->activeLocale]);
    // }
}
