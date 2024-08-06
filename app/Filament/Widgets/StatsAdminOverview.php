<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\LocationProduct;
use App\Models\TravelPackage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Travel Packages', TravelPackage::query()->count())
                ->description('Total Travel Paket yang dibuat')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Visa Document', Document::query()->count())
                ->description('Total Dokumen Visa yang dibuat')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Location Product', LocationProduct::query()->count())
                ->description('Total Lokasi Produk yang dibuat')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
