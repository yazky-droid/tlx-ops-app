<?php
namespace App\Filament\Resources\ShipmentResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Shipment;

/**
 * @property Shipment $resource
 */
class ShipmentTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
