<?php

namespace App\Filament\Resources\ShipmentResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ShipmentResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ShipmentResource\Api\Transformers\ShipmentTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = ShipmentResource::class;


    /**
     * Show Shipment
     *
     * @param Request $request
     * @return ShipmentTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->with('invoice')
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new ShipmentTransformer($query);
    }
}
