<?php

namespace App\Filament\Widgets;

use App\Models\Shipment;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestShipments extends BaseWidget
{
        protected static ?string $heading = 'Aktivitas Kiriman Terbaru';
        protected int | string | array $columnSpan = 'full';
        protected static ?int $sort = 2; 

        // untuk tampilin 5 kiriman terakhir

        protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
        {
            return Shipment::latest()->limit(5);
        }

        protected function getTableColumns(): array
        {
            return [
                TextColumn::make('reference_no')->label('No. Ref')->searchable(),
                TextColumn::make('shipper.name')->label('Shipper'),
                TextColumn::make('destination_port')->label('Tujuan'),
                TextColumn::make('current_status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'Delivered' => 'success',
                    'Cancelled' => 'danger',
                    'Booked' => 'gray',
                    default => 'warning',
                }),
                TextColumn::make('created_at')->label('Dibuat')->since(),
            ];
        }
}
