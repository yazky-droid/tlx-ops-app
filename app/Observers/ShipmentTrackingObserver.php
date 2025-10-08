<?php

namespace App\Observers;

use App\Models\ShipmentTracking;

class ShipmentTrackingObserver
{
    /**
     * Handle the ShipmentTracking "created" event.
     * pas ada data dibuat si function ini dijalankan
     */
    public function created(ShipmentTracking $shipmentTracking): void
    {
        // ambil data shipment yang baru aja diupdate trackingnya
        $shipment = $shipmentTracking->shipment;

        if ($shipment) {
            // Set status shipment dengan status terbaru dari tracking log
            $shipment->current_status = $shipmentTracking->status_name;
            $shipment->save();
        }
    }

    /**
     * Handle the ShipmentTracking "updated" event.
     */
    public function updated(ShipmentTracking $shipmentTracking): void
    {
        //
    }

    /**
     * Handle the ShipmentTracking "deleted" event.
     */
    public function deleted(ShipmentTracking $shipmentTracking): void
    {
        //
    }

    /**
     * Handle the ShipmentTracking "restored" event.
     */
    public function restored(ShipmentTracking $shipmentTracking): void
    {
        //
    }

    /**
     * Handle the ShipmentTracking "force deleted" event.
     */
    public function forceDeleted(ShipmentTracking $shipmentTracking): void
    {
        //
    }
}
