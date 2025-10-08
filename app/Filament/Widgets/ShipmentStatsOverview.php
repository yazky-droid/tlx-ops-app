<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ShipmentStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Kiriman', Shipment::count())
                ->description('Total kiriman yang tercatat')
                ->color('primary'),

            Stat::make('Dalam Proses', Shipment::whereIn('current_status', ['Cargo Picked Up', 'In Transit', 'Clearance Process'])->count())
                ->description('Sedang dalam perjalanan atau pemrosesan')
                ->color('warning'),

            Stat::make('Selesai (Delivered)', Shipment::where('current_status', 'Delivered')->count())
                ->description('Kiriman telah tiba di tujuan')
                ->color('success'),
                
            Stat::make('Invoice Belum Dibayar', \App\Models\Invoice::where('status', 'Draft')->count())
                ->description('Tagihan yang perlu ditindaklanjuti')
                ->color('danger'),
        ];
    }
}
