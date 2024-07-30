<?php

namespace App\Filament\Resources\TravelPackageResource\Pages;

use App\Filament\Resources\TravelPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTravelPackage extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = TravelPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
