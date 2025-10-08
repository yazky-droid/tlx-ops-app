<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditShipment extends EditRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('buatInvoice')
                ->label('Create Invoice')
                ->icon('heroicon-o-document-plus')
                ->color('info')
                ->hidden(fn (Model $record): bool => $record->invoice()->exists())
                ->url(fn (Model $record): string => InvoiceResource::getUrl('create', [
                    // passing shipment id
                    'shipmentId' => $record->id, 
                    // passing shipper_id untuk billed to inv
                    'clientId' => $record->shipper_id ?? $record->consignee_id,
                ])),
                
            Actions\DeleteAction::make(),
        ];
    }
}
